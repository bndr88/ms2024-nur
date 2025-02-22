<?php

use Mod2Nur\Presentacion\Controladores\TipoDiagController;
use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Presentacion\Mediator\CommandBus;
use Mod2Nur\Presentacion\Mediator\Mediator;

class TipoDiagControllerTest extends TestCase
{
    
    public function testCrearNuevoTipoDeDiagnostico()
    {
        //Arrange'
            $faker = Factory::create();
            $descripcion = $faker->sentence();
            $data = [
                'descripcion'=> $descripcion
            ];
            
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';   
            /*$unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);*/
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); --> Por si queremos insertar de verdad en la BD
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $commandBusMock->method('dispatch')->willReturn(new TipoDiagnostico('',$descripcion));

        //Act
            // Instanciar controladores con CommandBus
            $tipoDiagController = new TipoDiagController($commandBusMock);
            $tipoDiagnostico = $tipoDiagController->addTipoDiagnostico($data);

        //Assert
        $this->assertNotEmpty($tipoDiagnostico->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $tipoDiagnostico->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($descripcion, $tipoDiagnostico->getDescripcion());
        
    }

}