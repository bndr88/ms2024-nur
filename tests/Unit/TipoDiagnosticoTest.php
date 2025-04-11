<?php

namespace Tests\Unit;

use DateTime;
use InvalidArgumentException;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use PHPUnit\Framework\TestCase;
use Mockery;

class TipoDiagnosticoTest extends TestCase
{
	public function testConstructorGeneraUuidAutomaticamente()
	{
		//Arrange
		$descripcion = 'Diagnostico Inicial';

		//Act
		$tipoDiagnostico = new TipoDiagnostico('', $descripcion);
		$uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

		//Assert
		$this->assertNotEmpty($tipoDiagnostico->getId());
		$this->assertMatchesRegularExpression($uuidRegex, $tipoDiagnostico->getId(), 'El ID generado no tiene un formato UUID válido.');
		$this->assertSame($descripcion, $tipoDiagnostico->getDescripcion());
	}

	public function testConstructorAceptaUuid()
	{
		//Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$descripcion = 'Diagnostico Inicial';

		//Act
		$tipoDiagnostico = new TipoDiagnostico($id, $descripcion);

		//Assert
		$this->assertSame($id, $tipoDiagnostico->getId());
		$this->assertSame($descripcion, $tipoDiagnostico->getDescripcion());
	}

	public function testConstructorLanzaExcepcionConUuidInvalido()
	{
		//Arrange
		$idInvalido = 'id-invalido';
		$descripcion = 'Diagnostico Inicial';

		//Assert
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('El ID proporcionado no tiene un formato UUID válido.');
		//Act
		$tipoDiagnostico = new TipoDiagnostico($idInvalido, $descripcion);
	}

	public function testSettersYGetters()
	{
		// Arrange
		$descripcion = 'Inicial';
		$nuevaDescripcion = 'Rutinaria';
		//Act
		$tipoDiagnostico = new TipoDiagnostico('', $descripcion);

		// Act
		$tipoDiagnostico->setDescripcion($nuevaDescripcion);
		//$descripcionActualizada = $tipoDiagnostico->getDescripcion();

		// Assert
		$this->assertSame($nuevaDescripcion, $tipoDiagnostico->getDescripcion(), 'El UUID no se estableció correctamente.');
	}

}
