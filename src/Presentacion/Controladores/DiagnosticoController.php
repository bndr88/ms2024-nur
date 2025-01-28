<?php

namespace Mod2Nur\Presentacion\Controladores;

use DateTime;
use Exception;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Commands\RemDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddDiagnosticoHandler;
use Mod2Nur\Aplicacion\Paciente\Queries\GetPacienteByIdQuery;
use Mod2Nur\Presentacion\Mediator\CommandBus;
use Mod2Nur\Presentacion\Mediator\QueryBus;

class DiagnosticoController
{
    private AddDiagnosticoHandler $removeHandler;
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function crearDiagnostico(array $data)
    {
        $pacienteId = $data['idPaciente'];
        $query = new GetPacienteByIdQuery($pacienteId);

        // Pasar el Query al QueryBus mediante el método "ask" del Mediator
        $paciente = $this->queryBus->ask($query);

        if (!$paciente) {
            throw new \Exception("Paciente no encontrado");
        }

        try {
            $fechaDiagnostico = new DateTime($data['fechaDiagnostico']);
        } catch (Exception $e) {
            throw new Exception("Invalid date format for fechaDiagnostico.");
        }
        
        $command = new AddDiagnosticoCommand(
            $paciente->getId(),
            $data['peso'],
            $data['altura'],
            $data['composicion'],
            $data['estadoDiagnostico'],
            $data['idTipoDiagnostico'],
            $fechaDiagnostico 
        );

        $resultado = $this->commandBus->dispatch($command);
        return $resultado;
    }

    public function eliminarDiagnostico(string $id)
    {
        try {
            $command = new RemDiagnosticoCommand($id);
            $this->commandBus->dispatch($command);
            http_response_code(200);
        } catch (\Exception $e) {
            http_response_code(400);
        }
    }

    /*public function obtenerDiagnostico(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        $query = new ObtenerDiagnosticoQuery($id);

        $diagnostico = $this->mediator->handle($query);

        $response->getBody()->write(json_encode($diagnostico));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function actualizarDiagnostico(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

        $command = new ActualizarDiagnosticoCommand(
            $id,
            $data['peso'],
            $data['altura'],
            $data['composicion'],
            $data['estadoDiagnostico'],
            $data['tipoDiagnostico']
        );

        $resultado = $this->mediator->handle($command);

        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json');
    }
    */
}