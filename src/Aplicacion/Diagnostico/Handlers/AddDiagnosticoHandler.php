<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Handlers;

use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Diagnostico\DiagnosticoRepository;
use Mod2Nur\Dominio\Paciente\PacienteRepository;
use Illuminate\Database\DatabaseManager;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnosticoRepository;
use Mod2Nur\Dominio\Outbox\OutboxMessage;
use Mod2Nur\Dominio\Outbox\OutboxRepository;
use Ramsey\Uuid\Uuid;
use DateTime;

class AddDiagnosticoHandler
{
	private DiagnosticoRepository $diagnosticoRepository;
	private TipoDiagnosticoRepository $tipoDiagRepository;
	private PacienteRepository $pacienteRepository;
	private DatabaseManager $db;
    private OutboxRepository $outboxRepository;

	public function __construct(DiagnosticoRepository $diagnosticoRepository,
								TipoDiagnosticoRepository $tipoDiagRepository,
								PacienteRepository $pacienteRepository,
        						OutboxRepository $outboxRepository,
								DatabaseManager $DBManager)
	{
		$this->diagnosticoRepository = $diagnosticoRepository;
		$this->tipoDiagRepository = $tipoDiagRepository;
		$this->pacienteRepository = $pacienteRepository;
		$this->outboxRepository = $outboxRepository;
		$this->db = $DBManager;
	}

	public function __invoke(AddDiagnosticoCommand $command): ?Diagnostico
	{
		$paciente = $this->pacienteRepository->findById($command->pacienteId);

		if (!$paciente) {
			throw new \InvalidArgumentException('Paciente no encontrado.');
		}

		$tipoDiagnostico = $this->tipoDiagRepository->findById($command->tipoDiagnosticoId);

		if (!$tipoDiagnostico) {
			throw new \InvalidArgumentException('Tipo de Diagnóstico no encontrado.');
		}

		$estadoDiagnostico =  EstadoDiagnostico::from($command->estadoDiagnostico);

		if (!$estadoDiagnostico) {
			throw new \InvalidArgumentException('Estado de Diagnóstico incorrecto.');
		}

		try {
			//$diagnostico = new Diagnostico();
			$this->db->transaction(function () use ($command, $paciente, $tipoDiagnostico, $estadoDiagnostico, &$diagnostico) {

				$diagnostico = new Diagnostico(
					id: '',
					paciente: $paciente,
					fecha: $command->fechaDiagnostico,
					peso: $command->peso,
					altura: $command->altura,
					descripcion: $command->descripcion,
					estadoDiagnostico: $estadoDiagnostico,
					tipoDiagnostico: $tipoDiagnostico
				);
				// Intentar guardar en el repositorio
				if (!$this->diagnosticoRepository->save($diagnostico)) {
					throw new \RuntimeException('Error al guardar el diagnóstico en el repositorio.');
				}
			});
			// Si todo salió bien, la transacción hará commit automáticamente.
			$this->db->commit();
			//registrar el evento en el outbox
			//!----Agregar try-catch para presentación final y registrar en la observabilidad
			$this->outboxRepository->guardar(new OutboxMessage(
				id: Uuid::uuid4()->toString(),
				tipo: 'diagnostico-realizado',
				contenido: [
					'id' => (string)$diagnostico->getId(),
					'pacienteId' => $diagnostico->getPaciente()->getId(),
					'descripcion' => $diagnostico->getDescripcion(),
					// 'fecha' => $diagnostico->getFecha()->format('Y-m-d'),
				],
				fechaCreacion: new DateTime()
			));
			return $diagnostico;
		} catch (\Exception $e) {
			// Si ocurre cualquier excepción, se realizará un rollback automáticamente
			throw new \RuntimeException('Error durante la transacción: ' . $e->getMessage(), 0, $e);
		}
	}
}
