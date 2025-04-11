<?php

namespace Tests\Unitarios;

use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use PHPUnit\Framework\TestCase;
use DateTime;
use DomainException;
use InvalidArgumentException;
use Mod2Nur\Dominio\Diagnostico\AnalisisClinico;
use TypeError;

class DiagnosticoTest extends TestCase
{
	public function testLanzaExcepcionConstructorAsignaValoresIncorrectos()
	{
		// Arrange
		$id = null;
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);

		// Assert
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Parámetros no válidos');

		// Act
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

	}
	public function testConstructorAsignaValoresCorrectamente()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];

		// Act
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);
		$diagnostico->setAnalisisSolicitados($analisisSolicitados);
		// Assert
		$this->assertSame($id, $diagnostico->getId());
		$this->assertSame($descripcion, $diagnostico->getDescripcion());
		$this->assertEquals($fecha, $diagnostico->getFecha());
		$this->assertSame($pacienteMock, $diagnostico->getPaciente());
		$this->assertSame($peso, $diagnostico->getPeso());
		$this->assertSame($altura, $diagnostico->getAltura());
		$this->assertSame($descripcion, $diagnostico->getDescripcion());
		$this->assertSame($estadoDiagnostico, $diagnostico->getEstadoDiagnostico());
		$this->assertSame($tipoDiagnosticoMock, $diagnostico->getTipoDiagnostico());
		$this->assertSame($analisisSolicitados, $diagnostico->getAnalisisSolicitados());
	}

	public function testConstructorGeneraUuidCuandoIdEsVacio()
	{
		// Arrange
		$idVacio = '';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];

		// Act
		$diagnostico = new Diagnostico($idVacio, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);
		$diagnostico->setAnalisisSolicitados($analisisSolicitados);
		// Assert
		$this->assertNotEmpty($diagnostico->getId(), 'El ID generado no debería estar vacío.');

		$uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
		$this->assertMatchesRegularExpression($uuidRegex, $diagnostico->getId(), 'El ID generado no tiene un formato UUID válido.');
		$this->assertSame($descripcion, $diagnostico->getDescripcion());
		$this->assertEquals($fecha, $diagnostico->getFecha());
		$this->assertSame($pacienteMock, $diagnostico->getPaciente());
		$this->assertSame($peso, $diagnostico->getPeso());
		$this->assertSame($altura, $diagnostico->getAltura());
		$this->assertSame($descripcion, $diagnostico->getDescripcion());
		$this->assertSame($estadoDiagnostico, $diagnostico->getEstadoDiagnostico());
		$this->assertSame($tipoDiagnosticoMock, $diagnostico->getTipoDiagnostico());
		$this->assertSame($analisisSolicitados, $diagnostico->getAnalisisSolicitados());

	}

	public function testActualizarDiagnostico()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		$nuevoPeso = 75.0;
		$nuevaAltura = 1.80;
		$nuevaDescripcion = 'Diagnóstico actualizado';

		//act
		$diagnostico->actualizarDiagnostico($nuevoPeso, $nuevaAltura, $nuevaDescripcion);

		//Assert
		$this->assertSame($nuevoPeso, $diagnostico->getPeso());
		$this->assertSame($nuevaAltura, $diagnostico->getAltura());
		$this->assertSame($nuevaDescripcion, $diagnostico->getDescripcion());
	}

	public function testGettersYSetters()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		// Act
		$nuevaFecha = new DateTime('2024-02-21');
		$nuevoPacienteMock = $this->createMock(Paciente::class);
		$nuevoPeso = 75.0;
		$nuevaAltura = 1.80;
		$nuevaDescripcion = 'Diagnóstico actualizado';
		$nuevoEstadoDiagnosticoMock = EstadoDiagnostico::CONCLUIDO;
		$nuevoTipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$nuevosAnalisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];

		$diagnostico->setFecha($nuevaFecha);
		$diagnostico->setPaciente($nuevoPacienteMock);
		$diagnostico->setPeso($nuevoPeso);
		$diagnostico->setAltura($nuevaAltura);
		$diagnostico->setDescripcion($nuevaDescripcion);
		$diagnostico->setEstadoDiagnostico($nuevoEstadoDiagnosticoMock);
		$diagnostico->setTipoDiagnostico($nuevoTipoDiagnosticoMock);
		$diagnostico->setAnalisisSolicitados($nuevosAnalisisSolicitados);

		// Assert
		$this->assertSame($nuevoPacienteMock, $diagnostico->getPaciente());
		$this->assertEquals($nuevaFecha, $diagnostico->getFecha());
		$this->assertSame($nuevoPeso, $diagnostico->getPeso());
		$this->assertSame($nuevaAltura, $diagnostico->getAltura());
		$this->assertSame($nuevaDescripcion, $diagnostico->getDescripcion());
		$this->assertSame($nuevoEstadoDiagnosticoMock, $diagnostico->getEstadoDiagnostico());
		$this->assertSame($nuevoTipoDiagnosticoMock, $diagnostico->getTipoDiagnostico());
		$this->assertSame($nuevosAnalisisSolicitados, $diagnostico->getAnalisisSolicitados());
	}

	public function testAgregarAnalisisClinicos()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		$analisisMock = $this->createMock(AnalisisClinico::class);

		// Act
		$diagnostico->addAnalisisClinico($analisisMock);
		$analisis = $diagnostico->getAnalisisSolicitados();

		// Assert
		$this->assertEquals($analisisMock, $analisis[0], 'El analisis no se agregó corrrectamente.');

	}

	public function testIntentarAgregarAnalisisClinicosADiagnosticoConcluido()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::CONCLUIDO;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		$analisisMock = $this->createMock(AnalisisClinico::class);

		// Assert
		$this->expectException(DomainException::class);
		$this->expectExceptionMessage('No se pueden agregar análisis a un diagnóstico concluido.');

		// Act
		$diagnostico->addAnalisisClinico($analisisMock);

	}

	public function testRemoverAnalisisClinicos()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisSolicitados = [
			$this->createMock(AnalisisClinico::class),
			$this->createMock(AnalisisClinico::class),
		];
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		$analisisMock = $this->createMock(AnalisisClinico::class);

		// Simular que el analisis tiene un ID específico
		$analisisMock->method('getId')->willReturn("123e4567-e89b-12d3-a456-426614174000");

		// Agregar el analisis a un diagnostico
		$diagnostico->addAnalisisClinico($analisisMock);

		// Verificar que el analisis fue agregado
		$this->assertCount(1, $diagnostico->getAnalisisSolicitados());

		// Remover el analisis
		$diagnostico->removeAnalisisClinico($analisisMock->getId());

		// Verificar que el diagnóstico fue eliminado
		$this->assertCount(0, $diagnostico->getAnalisisSolicitados());

	}

	public function testConcluirDiagnostico()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisMock = $this->createMock(AnalisisClinico::class);
		$analisisMock->method('isConcluido')->willReturn(true);
		$analisisSolicitados = [
			$analisisMock,
			$analisisMock,
		];
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		// Act
		$diagnostico->setAnalisisSolicitados($analisisSolicitados);
		$diagnostico->concluirDiagnostico();

		// Assert
		$this->assertEquals(EstadoDiagnostico::CONCLUIDO, $diagnostico->getEstadoDiagnostico(), 'El diagnostico no se concluyó corrrectamente.');

	}

	public function testExcepcionEnConcluirDiagnostico()
	{
		// Arrange
		$id = '123e4567-e89b-12d3-a456-426614174000';
		$pacienteMock = $this->createMock(Paciente::class);
		$fecha = new DateTime('2024-02-20');
		$peso = 70.5;
		$altura = 1.75;
		$descripcion = 'Paciente presenta síntomas de fiebre y tos persistente.';
		$estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
		$tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);
		$analisisMock = $this->createMock(AnalisisClinico::class);
		$analisisMock->method('isConcluido')->willReturn(false);
		$analisisSolicitados = [
			$analisisMock,
			$analisisMock,
		];
		$diagnostico = new Diagnostico($id, $pacienteMock, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnosticoMock);

		$diagnostico->setAnalisisSolicitados($analisisSolicitados);

		// Assert
		$this->expectException(DomainException::class);
		$this->expectExceptionMessage('No se puede concluir el diagnóstico si hay análisis pendientes.');

		// Act
		$diagnostico->concluirDiagnostico();

	}

}
