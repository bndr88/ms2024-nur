<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddTipoDiagnosticoCommand;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Dominio\Paciente\Paciente;

class AddDiagnosticoCommandTest extends TestCase
{
	public function testConstructorConFechaString()
	{
		$FechaEnString = new DateTime('2024-02-21');
		$PacienteMock = $this->createMock(Paciente::class);
		$Peso = 75.0;
		$Altura = 1.80;
		$Descripcion = 'Diagnóstico actualizado';
		$EstadoDiagnosticoMock = EstadoDiagnostico::CONCLUIDO;
		$TipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);

		$command = new AddDiagnosticoCommand(
			$PacienteMock->getId(),
			$FechaEnString,
			$Peso,
			$Altura,
			$Descripcion,
			"Concluido",
			$TipoDiagnosticoMock->getId()
		);

		$this->assertSame($Descripcion, $command->getDescripcion());
	}
}
