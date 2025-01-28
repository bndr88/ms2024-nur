<?php

namespace Tests\Unit;

use Mod2Nur\Dominio\Paciente\Paciente;
use PHPUnit\Framework\TestCase;
use DateTime;
use InvalidArgumentException;
use TypeError;

class PacienteTest extends TestCase
{
    public function testConstructorGeneraUuidAutomaticamente()
    {
        //Arrange
        $nombre = 'Juan Perez';
        $fechaNacimiento = new DateTime('2000-01-01');

        //Act
        $paciente = new Paciente('', $nombre, $fechaNacimiento);
        $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';    

        //Assert
        $this->assertNotEmpty($paciente->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $paciente->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($nombre, $paciente->getNombre());
        $this->assertEquals($fechaNacimiento, $paciente->getFechaNacimiento());
    }

    public function testConstructorAceptaUUID()
    {
        //Arrange
        $id = '123e4567-e89b-12d3-a456-426614174000';
        $nombre = 'Maria Lopez';
        $fechaNacimiento = new DateTime('1990-05-15');

        //Act
        $paciente = new Paciente($id, $nombre, $fechaNacimiento);

        //Assert
        $this->assertSame($id, $paciente->getId());
        $this->assertSame($nombre, $paciente->getNombre());
        $this->assertEquals($fechaNacimiento, $paciente->getFechaNacimiento());
    }

    public function testConstructorAceptaUuidValido()
    {
        //Arrange
        $idValido = '123e4567-e89b-12d3-a456-426614174000';         
        $nombre = 'Maria Lopez';
        $fechaNacimiento = new DateTime('1990-05-15');
        //Act
        $paciente = new Paciente($idValido, $nombre, $fechaNacimiento);
        //Assert
        $this->assertSame($idValido, $paciente->getId(), 'El constructor no asignó correctamente un UUID válido.');
    }

    public function testConstructorLanzaExcepcionConUuidInvalido()
    {
        //Arrange 
        $idInvalido = 'id-invalido'; 
        $nombre = 'Maria Lopez';
        $fechaNacimiento = new DateTime('1990-05-15');
        //Assert 
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El ID proporcionado no tiene un formato UUID válido.');
        //Act
        new Paciente($idInvalido, $nombre, $fechaNacimiento);
    }

    public function testConstructorGeneraUuidCuandoIdEsVacio()
    {
        // Arrange
        $idVacio = ''; // ID vacío
        $nombre = 'Maria Lopez';
        $fechaNacimiento = new DateTime('1990-05-15');

        // Act
        $paciente = new Paciente($idVacio, $nombre, $fechaNacimiento);

        // Assert
        $this->assertNotEmpty($paciente->getId(), 'El ID generado no debería estar vacío.');

        $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
        $this->assertMatchesRegularExpression($uuidRegex, $paciente->getId(), 'El ID generado no tiene un formato UUID válido.');
    }


    public function testConstructorLanzaExcepcionConParametrosNulos()
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        new Paciente(null, null, null);
    }

    public function testSettersYGetters()
    {
        // Arrange
        $nombre = 'Carlos Gomez';
        $fechaNacimiento = new DateTime('1985-07-20');
        $nuevoNombre = 'Carlos Andres Gomez';
        $nuevaFechaNacimiento = new DateTime('1985-08-20');
        $paciente = new Paciente('', $nombre, $fechaNacimiento);

        // Act
        $paciente->setNombre($nuevoNombre);
        $paciente->setFechaNacimiento($nuevaFechaNacimiento);

        // Assert
        $this->assertSame($nuevoNombre, $paciente->getNombre(), 'El nombre no se estableció correctamente.');
        $this->assertEquals($nuevaFechaNacimiento, $paciente->getFechaNacimiento(), 'La fecha de nacimiento no se estableció correctamente.');
    }

    public function testHistorialYEntrevistasInicialmenteVacias()
    {
        // Arrange
        $paciente = new Paciente('', 'Laura Martinez', new DateTime('1995-03-10'));

        // Assert
        $this->assertEmpty($paciente->getHistorial(), 'El historial debería estar vacío inicialmente.');
        $this->assertEmpty($paciente->getEntrevistas(), 'Las entrevistas deberían estar vacías inicialmente.');
    }

}
