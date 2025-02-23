<?php

namespace Tests\Unit;

use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Mod2Nur\Aplicacion\Paciente\Commands\AddPacienteCommand;

class AddPacienteCommandTest extends TestCase
{
    public function testConstructorConFechaStringValida()
    {
        $faker = Factory::create();
        $nombre =  $faker->name(); 
        $fechaString =  $faker->date();
        $fechaNacimiento = new DateTime( $fechaString );

        $command = new AddPacienteCommand($nombre, $fechaNacimiento);

        $this->assertEquals($nombre, $command->nombre);
        $this->assertInstanceOf(DateTime::class, $command->fechaNacimiento);
        $this->assertEquals($fechaNacimiento , $command->fechaNacimiento);
    }

    public function testConstructorConObjetoDatetime()
    {
        $faker = Factory::create();
        $nombre =  $faker->name(); 
        $fechaString =  $faker->date();
        $fechaNacimiento = new DateTime( $fechaString );

        $command = new AddPacienteCommand($nombre, $fechaNacimiento);

        $this->assertEquals($nombre, $command->nombre);
        $this->assertInstanceOf(DateTime::class, $command->fechaNacimiento);
        $this->assertEquals($fechaNacimiento , $command->fechaNacimiento);
    }

    public function testConstructorConFormatoFechaInvalida()
    {
        // Caso con un formato de fecha inválido
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Formato de fecha inválido:");

        $nombre = "Carlos García";
        $fechaNacimiento = "invalid-date";

        new AddPacienteCommand($nombre, $fechaNacimiento);
    }

    
}