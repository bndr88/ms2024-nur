<?php

namespace Tests\Unit;

use DateTime;

use PHPUnit\Framework\TestCase;
use Mockery;
use InvalidArgumentException;
use Mod2Nur\Dominio\Abstracciones\Entity;
use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Paciente\Paciente;

class EntityTest extends TestCase
{
    public function testSettersYGetters()
    {
        // Arrange
        $nuevoId = '123e4567-e89b-12d3-a456-426614174000';     
        $nombre = 'Maria Lopez';
        $fechaNacimiento = new DateTime('1990-05-15');
        //Act
        $paciente = new Paciente('', $nombre, $fechaNacimiento);

        // Act
        $paciente->setId($nuevoId);

        // Assert
        $this->assertSame($nuevoId, $paciente->getId(), 'El UUID no se estableció correctamente.');
    }

    public function testFuncionEquals()
    {
        // Arrange     
        $nombrePaciente1 = 'Maria Lopez';
        $fechaNacimientoPaciente1 = new DateTime('1990-05-15');
        $nombrePaciente2 = 'Maria Lopez';
        $fechaNacimientoPaciente2 = new DateTime('1990-05-15');
        //Act
        $paciente1 = new Paciente('', $nombrePaciente1, $fechaNacimientoPaciente1);
        $paciente2 = new Paciente('', $nombrePaciente2, $fechaNacimientoPaciente2);

        // Act
        $respuesta = $paciente1->equals($paciente2);

        // Assert
        $this->assertFalse($respuesta,  'Las entidades no son iguales.');
    }

    public function testDebeLanzarExcepcionSiElIdEstaVacio()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El ID proporcionado no puede estar vacío.');

        new class('') extends Entity {
            protected function esUuidValido(string $id): bool
            {
                return true; // Simulación para evitar la segunda validación
            }
        };
    }
}