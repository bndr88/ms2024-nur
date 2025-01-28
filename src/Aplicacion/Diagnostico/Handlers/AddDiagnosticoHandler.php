<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Handlers;

use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Diagnostico\DiagnosticoRepository;
use Mod2Nur\Dominio\Paciente\PacienteRepository;
use Illuminate\Database\DatabaseManager;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnosticoRepository;

class AddDiagnosticoHandler
{
    private DiagnosticoRepository $diagnosticoRepository;
    private TipoDiagnosticoRepository $tipoDiagRepository;
    private PacienteRepository $pacienteRepository;
    private DatabaseManager $db;

    public function __construct(DiagnosticoRepository $diagnosticoRepository, TipoDiagnosticoRepository $tipoDiagRepository, PacienteRepository $pacienteRepository, DatabaseManager $DBManager) {
        $this->diagnosticoRepository = $diagnosticoRepository;
        $this->tipoDiagRepository = $tipoDiagRepository;
        $this->pacienteRepository = $pacienteRepository;
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
            $diagnostico = null;
            $this->db->transaction(function () use ($command, $paciente,$tipoDiagnostico, $estadoDiagnostico, &$diagnostico) {
            
                $diagnostico = new Diagnostico(
                    id: '',
                    paciente: $paciente,
                    peso: $command->peso,
                    altura: $command->altura,
                    composicion: $command->composicion,
                    estadoDiagnostico: $estadoDiagnostico,
                    tipoDiagnostico: $tipoDiagnostico
                );
                // Intentar guardar en el repositorio
                if (!$this->diagnosticoRepository->save($diagnostico)) {
                    throw new \RuntimeException('Error al guardar el diagnóstico en el repositorio.');
                }
            });        
            // Si todo salió bien, la transacción hará commit automáticamente.
            return $diagnostico;
        } catch (\Exception $e) {
            // Si ocurre cualquier excepción, se realizará un rollback automáticamente
            throw new \RuntimeException('Error durante la transacción: ' . $e->getMessage(), 0, $e);
        }
    }
}

