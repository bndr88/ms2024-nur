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
use Faker\Factory;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddTipoDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddTipoDiagnosticoHandler;
use RuntimeException;

class AddTipoDiagnosticoHandlerTest extends TestCase
{
	private $tipoDiagRepository;
	private $pacienteRepository;
	private $handler;
	private $faker;

	protected function setUp(): void
	{
		$this->faker = Factory::create();
		$this->tipoDiagRepository = $this->createMock(TipoDiagnosticoRepository::class);
		$this->pacienteRepository = $this->createMock(PacienteRepository::class);
		//$this->db = $this->createMock(DatabaseManager::class);

		$this->handler = new AddTipoDiagnosticoHandler($this->tipoDiagRepository);
	}

	public function testHandleSuccessfullyCreatesDiagnostico()
	{
		$descripcion = $this->faker->sentence();
		$command = new AddTipoDiagnosticoCommand($descripcion);

		$this->tipoDiagRepository->method('save')->willReturn(true);

		$diagnostico = $this->handler->__invoke($command);
		$this->assertInstanceOf(TipoDiagnostico::class, $diagnostico);

	}

}
