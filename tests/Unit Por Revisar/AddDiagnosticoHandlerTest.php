<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddDiagnosticoHandler;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Dominio\Diagnostico\DiagnosticoRepository;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnosticoRepository;
use Mod2Nur\Dominio\Paciente\PacienteRepository;
use Illuminate\Database\DatabaseManager;
use InvalidArgumentException;
use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Aplicacion\Eventos\EventPublisher;
use Faker\Factory;
use RuntimeException;

class AddDiagnosticoHandlerTest extends TestCase
{
	private $diagnosticoRepository;
	private $tipoDiagRepository;
	private $pacienteRepository;

	private $eventPublisher;
	private $db;
	private $handler;
	private $faker;

	protected function setUp(): void
	{
		$this->faker = Factory::create();
		$this->diagnosticoRepository = $this->createMock(DiagnosticoRepository::class);
		$this->tipoDiagRepository = $this->createMock(TipoDiagnosticoRepository::class);
		$this->pacienteRepository = $this->createMock(PacienteRepository::class);
		$this->eventPublisher = $this->createMock(EventPublisher::class);
		$this->db = $this->createMock(DatabaseManager::class);

		$this->handler = new AddDiagnosticoHandler(
			$this->diagnosticoRepository,
			$this->tipoDiagRepository,
			$this->pacienteRepository,
			$this->eventPublisher,
			$this->db
		);
	}

	/*public function testHandleSuccessfullyCreatesDiagnostico()
	{

		$fechaString =  $this->faker->date();
		$fechaDiagnostico = new DateTime($fechaString);
		$peso = $this->faker->randomFloat(2, 1, 100);
		$altura = $this->faker->randomFloat(2, 1, 100);
		$descripcion = $this->faker->sentence();
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$pacienteMock = $this->createMock(Paciente::class);
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$command = new AddDiagnosticoCommand(
			$pacienteMock->getId(),
			$fechaDiagnostico,
			$peso,
			$altura,
			$descripcion,
			"Pendiente",
			$tipoDiagnosticoMock->getId(),
		);

		$diagnosticoDevuelto = new Diagnostico(
			'',
			$pacienteMock,
			$fechaDiagnostico,
			$peso,
			$altura,
			$descripcion,
			$estadoDiagnostico,
			$tipoDiagnosticoMock
		);

		$this->pacienteRepository->method('findById')->willReturn($pacienteMock);
		$this->tipoDiagRepository->method('findById')->willReturn($tipoDiagnosticoMock);

		$this->diagnosticoRepository->method('save')->willReturn($diagnosticoDevuelto);

		$diagnostico = $this->handler->__invoke($command);
		//$this->assertInstanceOf(Diagnostico::class, $diagnostico);
		$this->assertNull($diagnostico);
	}*/

}
