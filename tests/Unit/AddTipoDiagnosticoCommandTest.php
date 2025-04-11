<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddTipoDiagnosticoCommand;

class AddTipoDiagnosticoCommandTest extends TestCase
{
	public function testGetter()
	{
		$faker = Factory::create();
		$descripcion =  $faker->sentence();

		$command = new AddTipoDiagnosticoCommand($descripcion);

		$this->assertSame($descripcion, $command->getDescripcion());
	}
}
