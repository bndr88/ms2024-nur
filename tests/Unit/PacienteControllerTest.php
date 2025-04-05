<?php

use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Presentacion\Controladores\PacienteController;
use Mod2Nur\Presentacion\Mediator\CommandBus;
use Mod2Nur\Presentacion\Mediator\Mediator;
use Mod2Nur\Presentacion\Mediator\QueryBus;
use PHPUnit\Framework\TestCase;
use Mod2Nur\Aplicacion\Paciente\Servicios\CrearPacienteService;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Infraestructura\UnitOfWork;

class PacienteControllerTest extends TestCase
{
    public function testCrearNuevoPaciente()
    {
        //Arrange'
            $nombre = 'Pablo Marmol';
            $fechaNacimiento = new DateTime('2024-02-21');
            $data = [
                'nombre'=> $nombre,
                'fechaNacimiento'=> $fechaNacimiento,
            ];

            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); --> Por si queremos insertar de verdad en la BD
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $commandBusMock->method('dispatch')->willReturn(new Paciente('',$nombre , $fechaNacimiento));
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBusMock, $queryBus, $servicio,$unitOfWork);
            $paciente = $pacienteController->addPaciente($data);

        //Assert
        $this->assertNotEmpty($paciente->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $paciente->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($nombre, $paciente->getNombre());
        $this->assertEquals($fechaNacimiento, $paciente->getFechaNacimiento());

    }

    public function testCrearNuevoPacienteConUnitOfWork()
    {
        //Arrange'
            $nombre = 'Pablo Marmol';
            $fechaNacimiento = new DateTime('2024-02-21');
            $data = [
                'nombre'=> $nombre,
                'fechaNacimiento'=> $fechaNacimiento,
            ];
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
            // Instanciar lo necesario para trabajar con UnitOfWork
                //$repositorio = new EloquentPacienteRepository($unitOfWorkMock);--> Por si queremos insertar de verdad en la BD
                //$servicio = new CrearPacienteService($repositorio);--> Por si queremos insertar de verdad en la BD
            $unitOfWorkMock = $this->createMock(UnitOfWork::class);// Simula Crear el UnitOfWork
            $servicioMock = $this->createMock(CrearPacienteService::class);// Simula Crear el Servicio
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); --> Por si queremos insertar de verdad en la BD
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act

            $pacienteController = new PacienteController($commandBusMock, $queryBus, $servicioMock,$unitOfWorkMock);
            $paciente = $pacienteController->crearPacienteUnitOfWork($data);

        //Assert
        $this->assertNotEmpty($paciente->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $paciente->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($nombre, $paciente->getNombre());
        $this->assertEquals($fechaNacimiento, $paciente->getFechaNacimiento());

    }

    public function testCrearNuevoPacienteConUnitOfWorkSinMock()
    {
        //Arrange'
            $nombre = 'Pablo Marmol';
            $fechaNacimiento = new DateTime('2024-02-21');
            $data = [
                'nombre'=> $nombre,
                'fechaNacimiento'=> $fechaNacimiento,
            ];
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
                $repositorio = new EloquentPacienteRepository($unitOfWork);// Por si queremos insertar de verdad en la BD
                $servicio = new CrearPacienteService($repositorio);// Por si queremos insertar de verdad en la BD
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); //
            //$commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act

            $pacienteController = new PacienteController($commandBus, $queryBus, $servicio,$unitOfWork);
            $paciente = $pacienteController->crearPacienteUnitOfWork($data);

        //Assert
        $this->assertNotEmpty($paciente->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $paciente->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($nombre, $paciente->getNombre());
        $this->assertEquals($fechaNacimiento, $paciente->getFechaNacimiento());

    }

    /*public function testObtenerPacientePorId()
    {
        //Arrange'
            $pacienteId = "00607697-4a4d-44b8-898a-4f8eb31764c7";
            $nombreEsperado = "Lena Ullrich";
            $fechaNacimientoEsperado = "2007-03-18";
            $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBusMock, $queryBus, $servicio,$unitOfWork);
            $respuesta = $pacienteController->getPacienteById($pacienteId);
            $fecNac = DateTime::createFromFormat('d/m/Y', $respuesta['fechaNacimiento']);
            $paciente =  new Paciente($respuesta['id'],$respuesta['nombre'],$fecNac) ;

        //Assert
        $fechaString = $paciente->getFechaNacimiento()->format('Y-m-d');
        $this->assertNotEmpty($paciente->getId());
        $this->assertMatchesRegularExpression($uuidRegex, $paciente->getId(), 'El ID generado no tiene un formato UUID válido.');
        $this->assertSame($nombreEsperado, $paciente->getNombre());
        $this->assertEquals($fechaNacimientoEsperado, $fechaString );
    }*/

    public function testObtenerPacientePorIdFallido()
    {
        //Arrange'
            $pacienteId = "idInvalido";
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $queryBusMock = $this->createMock(QueryBus::class);// Simula Crear el CommandBus del Mediator
            $queryBusMock->method('ask')->willReturn(null);

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBusMock, $queryBusMock, $servicio,$unitOfWork);

        //Assert
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Paciente no encontrado');
        $respuesta = $pacienteController->getPacienteById($pacienteId);
    }

    public function testEliminarPaciente()
    {
        //Arrange'
            $pacienteId = "04c4ec8d-289d-4631-9ffb-df972d271f00";
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBus, $queryBus, $servicio,$unitOfWork);
            $pacienteController->destroy($pacienteId);
        // Assert
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Error al obtener el paciente: Paciente no encontrado');
        $respuesta = $pacienteController->getPacienteById($pacienteId);

    }

    public function testEliminarPacienteFallido()
    {
        //Arrange'
            $pacienteId = "04c4ec8d-289d-4631-9ffb-df972d271f00";
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            //$commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator

            $commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBusMock, $queryBus, $servicio,$unitOfWork);
            $commandBusMock->method('dispatch')->willThrowException(new \Exception("Error en eliminación"));
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        // Act
            ob_start();
            $pacienteController->destroy($pacienteId);
            ob_end_clean();

            // Assert
            $this->assertEquals(400, http_response_code());

    }

    public function testListarPacientes()
    {
        //Arrange'
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            //$commandBusMock = $this->createMock(CommandBus::class);// Simula Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBus, $queryBus, $servicio,$unitOfWork);
            $respuesta = $pacienteController->listar('');

        //Assert
        $this->assertNotEmpty($respuesta);
    }

    public function testObtenerHistorialClinico()
    {
        //Arrange'
            $pacienteId = "8287a232-1dd8-4901-9adf-b742f5739405";
            // Instanciar lo necesario para trabajar con UnitOfWork
            $unitOfWork = new UnitOfWork();
            $repositorio = new EloquentPacienteRepository($unitOfWork);
            $servicio = new CrearPacienteService($repositorio);
            // Configuración del Mediator
            $registryFactory = require __DIR__ . '/../../src/Presentacion/mediator.php';
            $registry = $registryFactory();
            $mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
            $commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
            $queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

        //Act
            // Instanciar controladores con CommandBus
            $pacienteController = new PacienteController($commandBus, $queryBus, $servicio,$unitOfWork);
            $respuesta = $pacienteController->getHistorialClinico($pacienteId);

        //Assert
        $this->assertNotEmpty($respuesta);
    }
}
