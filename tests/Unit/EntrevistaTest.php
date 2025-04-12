<?php

namespace Tests\Unit;

use DateTime;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Faker\Factory;
use Mod2Nur\Dominio\Entrevista\Entrevista;

class EntrevistaTest extends TestCase
{
	public function testConstructorAceptaUuidValido()
	{
		//Arrange
		$faker = Factory::create();
		$idValido = Uuid::uuid4()->toString();
		$fechaString =  $faker->date();
		$fechaRealizacion = new DateTime($fechaString);
		//Act
		$analisisClinico = new Entrevista($idValido, $fechaRealizacion);
		//Assert
		$this->assertSame($idValido, $analisisClinico->getId(), 'El constructor no asignó correctamente un UUID válido.');
	}

	public function testGetters()
	{
		//Arrange
		$faker = Factory::create();
		$idValido = Uuid::uuid4()->toString();
		$fechaString =  $faker->date();
		$fechaRealizacion = new DateTime($fechaString);
		//Act
		$analisisClinico = new Entrevista($idValido, $fechaRealizacion);
		//Assert
		$this->assertSame($fechaRealizacion, $analisisClinico->getFechaRealizacion(), 'Las fechas no son iguales');
	}

}
