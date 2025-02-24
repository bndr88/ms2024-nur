<?php

use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Presentacion\Controladores\DiagnosticoController;
use Mod2Nur\Presentacion\Mediator\CommandBus;
use Mod2Nur\Presentacion\Mediator\Mediator;
use Mod2Nur\Presentacion\Mediator\QueryBus;

class DiagnosticoControllerTest extends TestCase
{
    
    public function testCrearNuevoDiagnostico()
    {
        //Arrange'      
            $faker = Factory::create();
            $pacienteMock = $this->createMock(Paciente::class);
            $fechaString =  $faker->date();
            $fecha = new DateTime( $fechaString );
            $peso = $faker->randomFloat(2, 1, 100);
            $altura = $faker->randomFloat(2, 1, 100);
            $descripcion = $faker->sentence();
            $estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
            $tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);      
            $data = [
                'idPaciente'=> '00607697-4a4d-44b8-898a-4f8eb31764c7',
                'fechaDiagnostico' => $fechaString,
                'peso' => $peso,
                'altura' => $altura,
                'descripcion' => $descripcion,
                'estadoDiagnostico' => "PENDIENTE",
                'idTipoDiagnostico' => $tipoDiagnosticoMock->getId()
            ];
            
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';   
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); --> Por si queremos insertar de verdad en la BD
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $diagnosticoDevuelto = new Diagnostico('', $pacienteMock, $fecha,  $peso, $altura, 
                                                    $descripcion, $estadoDiagnostico, 
                                                    $tipoDiagnosticoMock);
            $commandBusMock->method('dispatch')->willReturn($diagnosticoDevuelto);
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $diagnosticoController = new DiagnosticoController($commandBusMock, $queryBus);
            $diagnostico = $diagnosticoController->crearDiagnostico($data);

        //Assert
        $this->assertNotEmpty($diagnostico->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $diagnostico->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($descripcion, $diagnostico->getDescripcion());
        
    }

    public function testCrearNuevoDiagnosticoSinMock()
    {
        //Arrange'      
            $faker = Factory::create();
            $pacienteMock = $this->createMock(Paciente::class);
            $fechaString =  $faker->date();
            $fecha = new DateTime( $fechaString );
            $peso = $faker->randomFloat(2, 1, 100);
            $altura = $faker->randomFloat(2, 1, 100);
            $descripcion = $faker->sentence();
            $estadoDiagnostico = EstadoDiagnostico::PENDIENTE;
            $tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);   
            $tipoDiagnosticoMock->method('getId')->willReturn('3d6272e4-1a09-4dc6-8eb2-d79ca96a7512');   
            $data = [
                'idPaciente'=> '00607697-4a4d-44b8-898a-4f8eb31764c7',
                'fechaDiagnostico' => $fechaString,
                'peso' => $peso,
                'altura' => $altura,
                'descripcion' => $descripcion,
                'estadoDiagnostico' => "Pendiente",
                'idTipoDiagnostico' => $tipoDiagnosticoMock->getId()
            ];
            
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';   
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); 
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $diagnosticoController = new DiagnosticoController($commandBus, $queryBus);
            $diagnostico = $diagnosticoController->crearDiagnostico($data);

        //Assert
        $this->assertNotEmpty($diagnostico->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $diagnostico->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($descripcion, $diagnostico->getDescripcion());
        
    }

    public function testCrearNuevoDiagnosticoSinPaciente()
    {
        //Arrange'      
            $data = [
                'idPaciente'=> '00607697-4a4d-44b8-898a-4f8eb31764c7',
            ];
            
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';   
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); --> Por si queremos insertar de verdad en la BD
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            
            $queryBusMock = $this->createMock(QueryBus::class);// Simula Crear el QueryBus del Mediator
            $queryBusMock->method('ask')->willReturn(null);

            $diagnosticoController = new DiagnosticoController($commandBusMock, $queryBusMock);
        
        //Assert
            $this->expectException(Exception::class);

        //Act
            $diagnosticoController->crearDiagnostico($data);        
    }

    public function testCrearNuevoDiagnosticoSinFecha()
    {
        //Arrange'      
        $faker = Factory::create();
        $pacienteMock = $this->createMock(Paciente::class);
        $peso = $faker->randomFloat(2, 1, 100);
        $altura = $faker->randomFloat(2, 1, 100);
        $descripcion = $faker->sentence();
        $tipoDiagnosticoMock = $this->createMock(TipoDiagnostico::class);      
        $data = [
            'idPaciente'=> '00607697-4a4d-44b8-898a-4f8eb31764c7',
            'fechaDiagnostico' => 'fecha-invalida',
            'peso' => $peso,
            'altura' => $altura,
            'descripcion' => $descripcion,
            'estadoDiagnostico' => "PENDIENTE",
            'idTipoDiagnostico' => $tipoDiagnosticoMock->getId()
        ]; 
        // Configuración del Mediator
        $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
        $registry = $registryFactory();
        //$commandBus = new CommandBus($mediator); --> Por si queremos insertar de verdad en la BD
        $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
        $queryBusMock = $this->createMock(QueryBus::class);// Simula Crear el QueryBus del Mediator
        $queryBusMock->method('ask')->willReturn($pacienteMock);

        //Act            
            $diagnosticoController = new DiagnosticoController($commandBusMock, $queryBusMock);
        
        //Assert
            $this->expectException(Exception::class);
            $this->expectExceptionMessage('Invalid date format for fechaDiagnostico.');

        //Act
            $diagnosticoController->crearDiagnostico($data);        
    }

    public function testEliminarDiagnosticoExitoso()
    {
        //Arrange'            
            $diagnosticoId = "04c4ec8d-289d-4631-9ffb-df972d271f00";
            
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            //$commandBusMock->method('dispatch')->willReturn($diagnosticoDevuelto);
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $diagnosticoController = new DiagnosticoController($commandBusMock, $queryBus);
           // $diagnosticoController->eliminarDiagnostico($diagnosticoId);
        // Act
            ob_start();
            $diagnosticoController->eliminarDiagnostico($diagnosticoId);
            ob_end_clean();

            // Assert
            $this->assertEquals(200, http_response_code());
        
    }

    public function testEliminarDiagnosticoFallido()
    {
        //Arrange'            
            $diagnosticoId = "04c4ec8d-289d-4631-9ffb-df972d271f00";
            
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $commandBusMock->method('dispatch')->willThrowException(new \Exception("Error en eliminación"));
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $diagnosticoController = new DiagnosticoController($commandBusMock, $queryBus);
           // $diagnosticoController->eliminarDiagnostico($diagnosticoId);
        // Act
            ob_start();
            $diagnosticoController->eliminarDiagnostico($diagnosticoId);
            ob_end_clean();

            // Assert
            $this->assertEquals(400, http_response_code());
        
    }

    public function testEliminarDiagnosticoSinMock()
    {
        //Arrange'            
            $diagnosticoId = "04c4ec8d-289d-4631-9ffb-df972d271f00";
            
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            //$commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            //$commandBusMock->method('dispatch')->willReturn($diagnosticoDevuelto);
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $diagnosticoController = new DiagnosticoController($commandBus, $queryBus);
            $diagnosticoController->eliminarDiagnostico($diagnosticoId);

            // Assert
            $this->assertEquals(200, http_response_code());
        
    }

    
}