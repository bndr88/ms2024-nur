<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Mod2Nur\Aplicacion\Paciente\Commands\AddPacienteCommand;
use Mod2Nur\Aplicacion\Paciente\Handlers\AddPacienteHandler;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Dominio\Paciente\PacienteRepository;

class AddPacienteHandlerTest extends TestCase
{
    private $repositoryMock;
    private $handler;
    private $faker;

    protected function setUp(): void
    {      
        $this->faker = Factory::create();  
        $this->repositoryMock = $this->createMock(PacienteRepository::class);
        $this->handler = new AddPacienteHandler($this->repositoryMock);
    }

    public function testInvokeDeberiaCrearYGuardarPaciente()
    {
        $nombre = $this->faker->name();  
        $fechaString =  $this->faker->date();
        $fechaNacimiento = new DateTime( $fechaString );
        $command = new AddPacienteCommand($nombre, $fechaNacimiento);

        // Esperamos que el método save del repositorio sea llamado una vez con un paciente
        $this->repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Paciente::class));

        // Ejecutamos el handler
        $paciente = $this->handler->__invoke($command);

        // Verificamos que se haya creado un paciente con el nombre y la fecha de nacimiento correctos
        $this->assertInstanceOf(Paciente::class, $paciente);
        $this->assertEquals($nombre, $paciente->getNombre());
        $this->assertEquals($fechaNacimiento, $paciente->getFechaNacimiento());
    }

    public function testInvokeDeberiaRetornarUnPaciente()
    {              
        $nombre = $this->faker->name();         
        $fechaString =  $this->faker->date();
        $fechaNacimiento = new DateTime( $fechaString );
        $command = new AddPacienteCommand($nombre, $fechaNacimiento);
        
        // Hacemos que el repositorio retorne el paciente simulado al llamar a save
        $this->repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Paciente::class));

        // Ejecutamos el handler
        $paciente = $this->handler->__invoke($command);

        // Verificamos que el paciente retornado es el simulado
        $this->assertInstanceOf(Paciente::class, $paciente);
    }   
}