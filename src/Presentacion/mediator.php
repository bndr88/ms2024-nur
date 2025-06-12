<?php

use Mod2Nur\Aplicacion\Paciente\Handlers\GetPacienteByIdHandler;
use Mod2Nur\Aplicacion\Paciente\Handlers\ListaPacientesHandler;
use Mod2Nur\Aplicacion\Paciente\Queries\GetListaPacientesQuery;
use Mod2Nur\Presentacion\Mediator\HandlersRegistry;
use Illuminate\Database\Capsule\Manager as Capsule;
use Mod2Nur\Aplicacion\Paciente\Handlers\AddPacienteHandler;
use Mod2Nur\Aplicacion\Paciente\Commands\AddPacienteCommand;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddDiagnosticoHandler;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddTipoDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Commands\RemDiagnosticoCommand;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddTipoDiagnosticoHandler;
use Mod2Nur\Aplicacion\Diagnostico\Handlers\RemDiagnosticoHandler;
use Mod2Nur\Aplicacion\Paciente\Commands\RemPacienteCommand;
use Mod2Nur\Aplicacion\Paciente\Handlers\GetHistorialHandler;
use Mod2Nur\Aplicacion\Paciente\Handlers\RemPacienteHandler;
use Mod2Nur\Aplicacion\Paciente\Queries\GetHistorialQuery;
use Mod2Nur\Aplicacion\Paciente\Queries\GetPacienteByIdQuery;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentDiagnosticoRepository;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentTipoDiagnosticoRepository;
use Mod2Nur\Infraestructura\Publicador\RabbitMQEventPublisher;
use Mod2Nur\Infraestructura\UnitOfWork;

return function (): HandlersRegistry {
	$registry = new HandlersRegistry();
	$capsule = require __DIR__ . '/../../env.php';
	$db = $capsule->getDatabaseManager();
	$UoW = new UnitOfWork();
	$repositoryPaciente = new EloquentPacienteRepository($UoW);
	$repositoryTipoDiag = new EloquentTipoDiagnosticoRepository();
	$repositoryDiagnostico = new EloquentDiagnosticoRepository();
	$eventPublisher = new RabbitMQEventPublisher();

	// Registro de Handlers para Commands y Queries
	$registry->register(AddPacienteCommand::class, new AddPacienteHandler($repositoryPaciente));
	$registry->register(RemPacienteCommand::class, new RemPacienteHandler($repositoryPaciente));
	$registry->register(GetPacienteByIdQuery::class, new GetPacienteByIdHandler($repositoryPaciente));
	$registry->register(GetListaPacientesQuery::class, new ListaPacientesHandler($repositoryPaciente));
	$registry->register(GetHistorialQuery::class, new GetHistorialHandler($repositoryPaciente));

	$registry->register(AddDiagnosticoCommand::class, new AddDiagnosticoHandler($repositoryDiagnostico, $repositoryTipoDiag, $repositoryPaciente,$eventPublisher, $db));
	$registry->register(RemDiagnosticoCommand::class, new RemDiagnosticoHandler($repositoryDiagnostico));

	$registry->register(AddTipoDiagnosticoCommand::class, new AddTipoDiagnosticoHandler($repositoryTipoDiag));

	return $registry;
};
