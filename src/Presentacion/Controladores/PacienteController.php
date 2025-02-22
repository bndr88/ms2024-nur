<?php

namespace Mod2Nur\Presentacion\Controladores;

use DateTime;
use Mod2Nur\Aplicacion\Paciente\Commands\AddPacienteCommand;
use Mod2Nur\Aplicacion\Paciente\Commands\RemPacienteCommand;
use Mod2Nur\Aplicacion\Paciente\Handlers\AddPacienteHandler;
use Mod2Nur\Aplicacion\Paciente\Handlers\RemPacienteHandler;
use Mod2Nur\Aplicacion\Paciente\Queries\GetPacienteByIdQuery;
use Mod2Nur\Aplicacion\Paciente\Servicios\CrearPacienteService;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Infraestructura\UnitOfWork;
use Mod2Nur\Presentacion\Mediator\CommandBus;
use Mod2Nur\Presentacion\Mediator\QueryBus;

class PacienteController
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    private CrearPacienteService $servicio;
    private UnitOfWork $unitOfWork;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, CrearPacienteService $servicio, ?UnitOfWork $unitOfWork)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;

        $this->servicio = $servicio;
        $this->unitOfWork = $unitOfWork;
    }

    public function crearPacienteUnitOfWork(array $data)
    {
        /*$fecNac = new DateTime($data['fechaNacimiento']);
        $paciente = new Paciente('',$data['nombre'], $fecNac);*/
        $paciente = new Paciente('',$data['nombre'], $data['fechaNacimiento']);
        $this->servicio->ejecutar($paciente);
        $this->unitOfWork->commit();
        return $paciente;
    }

    public function addPaciente(array $data)
    {
        // Crear el comando con los datos de entrada
        $command = new AddPacienteCommand($data['nombre'], $data['fechaNacimiento']);

        // Enviar el comando a través del Mediator (vía CommandBus)
        $paciente = $this->commandBus->dispatch($command);

        return $paciente;
    }

    public function getPacienteById(string $pacienteId)
    {
        try {
             // Crear el Query para obtener el paciente
             $query = new GetPacienteByIdQuery($pacienteId);

             // Pasar el Query al QueryBus mediante el método "ask" del Mediator
             $paciente = $this->queryBus->ask($query);
 
             if (!$paciente) {
                 throw new \Exception("Paciente no encontrado");
             }
            
             $fechaNac = $paciente->getFechaNacimiento()->format('d/m/Y');
            return [
                'id' => $paciente->getId(),
                'nombre' => $paciente->getNombre(),
                'fechaNacimiento' => $fechaNac,
            ];
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener el paciente: " . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $command = new RemPacienteCommand($id);
            //$this->removeHandler->handle($command);
            $paciente = $this->commandBus->dispatch($command);
            http_response_code(200);
        } catch (\Exception $e) {
            http_response_code(400);
        }
    }
}
