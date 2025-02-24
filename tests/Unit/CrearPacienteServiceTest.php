<?php

namespace Tests\Unit;

use DateTime;

use PHPUnit\Framework\TestCase;
use Mod2Nur\Aplicacion\Paciente\Servicios\CrearPacienteService;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Dominio\Paciente\PacienteCreadoEvent;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Infraestructura\UnitOfWork;

class CrearPacienteServiceTest extends TestCase
{
    public function testEjecutar()
    {
        //Arrange        
        $pacienteMock = $this->createMock(Paciente::class);
        $eloquentPacienteRepositoryMock = $this->createMock(EloquentPacienteRepository::class);
        $unitOfWorkMock = $this->createMock(UnitOfWork::class);

        // Verificar que se llame `saveConUnitOfWork` con el paciente
        $eloquentPacienteRepositoryMock
            ->expects($this->once())
            ->method('saveConUnitOfWork')
            ->with($pacienteMock);

        // Configurar el repositorio para que retorne el UnitOfWork mockeado
        $eloquentPacienteRepositoryMock
            ->expects($this->once()) // Verifica que se llame una vez
            ->method('getUnitOfWork')
            ->willReturn($unitOfWorkMock);

        // Verificar que se registre el evento en el UnitOfWork
        $unitOfWorkMock
            ->expects($this->once())
            ->method('registerDomainEvent')
            ->with($this->callback(function ($event) use ($pacienteMock) {
                return $event instanceof PacienteCreadoEvent &&
                    $event->getIdPaciente() === $pacienteMock->getId();
            }));
        //Act
        $crearPacienteService = new CrearPacienteService($eloquentPacienteRepositoryMock);
        $crearPacienteService->ejecutar($pacienteMock);
        //Assert
        //No se necesita un assert explícito, ya que las expectativas en los mocks funcionan como aserciones.
    }
    
}