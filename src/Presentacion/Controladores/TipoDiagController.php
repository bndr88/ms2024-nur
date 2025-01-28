<?php

namespace Mod2Nur\Presentacion\Controladores;

use Mod2Nur\Aplicacion\Diagnostico\Commands\AddTipoDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddTipoDiagnosticoHandler;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentTipoDiagnosticoRepository;
use Mod2Nur\Presentacion\Mediator\CommandBus;

class TipoDiagController
{
    private AddTipoDiagnosticoHandler $addHandler;
    //private RemTipoDiagnostico $removeHandler;
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function addTipoDiagnostico(array $data)
    {
        // Crear el comando con los datos de entrada
        $command = new AddTipoDiagnosticoCommand($data['descripcion']);

        // Enviar el comando a través del Mediator (vía CommandBus)
        $tipoDiagnostico = $this->commandBus->dispatch($command);

        // Retornar el resultado (o manejarlo según tu aplicación)
        return $tipoDiagnostico;
    }

    public function destroy(string $id)
    {
        /*try {
            $command = new RemPacienteCommand($id);
            $this->removeHandler->handle($command);

            http_response_code(200);
            echo json_encode(['message' => 'Paciente eliminado']);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }*/
    }
}
