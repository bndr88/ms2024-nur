<?php

namespace Mod2Nur\Presentacion;

use Mod2Nur\Aplicacion\Paciente\Servicios\CrearPacienteService;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Infraestructura\UnitOfWork;
use Mod2Nur\Presentacion\Controladores\DiagnosticoController;
use Mod2Nur\Presentacion\Mediator\Mediator;
use Mod2Nur\Presentacion\Mediator\CommandBus;
use Mod2Nur\Presentacion\Controladores\PacienteController;
use Mod2Nur\Presentacion\Controladores\TipoDiagController;
use Mod2Nur\Presentacion\Mediator\QueryBus;

// Permitir solicitudes desde cualquier origen (para evitar error 'CORS')
//header("Access-Control-Allow-Origin: http://tudominio.com"); Si se quiere acceder solo desde un dominio
header("Access-Control-Allow-Origin: *");
// Permitir métodos HTTP específicos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// Permitir ciertos encabezados
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Manejo de preflight (solicitudes OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	http_response_code(200);
	exit();
}

// Instanciar lo necesario para trabajar con UnitOfWork
$unitOfWork = new UnitOfWork();
$repositorio = new EloquentPacienteRepository($unitOfWork);
$servicio = new CrearPacienteService($repositorio);

// Configuración del Mediator
$registryFactory = require __DIR__ . '/mediator.php';
$registry = $registryFactory();
$mediator = new Mediator($registry); // Crear el Mediator con el registro de handlers
$commandBus = new CommandBus($mediator); // Crear el CommandBus del Mediator
$queryBus = new QueryBus($mediator); // Crear el CommandBus con el Mediator

// Instanciar controladores con CommandBus
$pacienteController = new PacienteController($commandBus, $queryBus, $servicio, $unitOfWork);
$tipoDiagController = new TipoDiagController($commandBus);
$diagnosticoController = new DiagnosticoController($commandBus, $queryBus);

// Manejo de rutas
if ($requestMethod === 'GET' && $requestUri === '/hola') {
	try {
		header('Content-Type: application/json');
		http_response_code(200);
		echo json_encode(['message' => 'Hola Mundo'], JSON_PRETTY_PRINT);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'POST' && $requestUri === '/paciente/add') {
	try {
		// Crear un paciente
		$data = json_decode(file_get_contents('php://input'), true);
		$paciente = $pacienteController->addPaciente($data);
		header('Content-Type: application/json');
		http_response_code(200);
		echo json_encode(['message' => 'Paciente creado', 'ID paciente registrado' => $paciente->getId()], JSON_PRETTY_PRINT);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'POST' && $requestUri === '/paciente/addUoW') {
	try {
		// Crear un paciente usando UnitOfWork
		$data = json_decode(file_get_contents('php://input'), true);
		$paciente = $pacienteController->crearPacienteUnitOfWork($data);
		http_response_code(201);
		echo json_encode(['message' => 'Paciente creado']);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'DELETE' && preg_match('#^/paciente/([\w-]+)$#', $requestUri, $matches)) {
	try {
		// Eliminar un paciente
		$id = $matches[1];
		$pacienteController->destroy($id);
		http_response_code(201);
		echo json_encode(['message' => 'Paciente con ID '.$id.' eliminado correctamente']);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'GET' && preg_match('#^/paciente/([a-f0-9\-]{36})$#', $requestUri, $matches)) {
	try {
		//Obtener un paciente
		$pacienteId = $matches[1];
		$response = $pacienteController->getPacienteById($pacienteId);
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'GET' && $requestUri === '/paciente/list') {
	try {
		//Obtener lista de pacientes
		$response = $pacienteController->listar('');
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

//if ($requestMethod === 'GET' && preg_match('#^/paciente/([a-f0-9\-]{36})$#/diag/', $requestUri, $matches)) {
if ($requestMethod === 'GET' && preg_match('#^/paciente/([a-f0-9\-]{36})/diag$#', $requestUri, $matches)) {
	try {
		//Obtener un paciente
		$pacienteId = $matches[1];
		$response = $pacienteController->getHistorialClinico($pacienteId);
		header('Content-Type: application/json');
		if (empty($response)) {
			http_response_code(400);
			echo json_encode(['error' => "El Paciente aun no tiene ningun Diagnostico"], JSON_PRETTY_PRINT);
		} elseif (isset($response['error']) && $response['error'] === 'paciente no existe') {
			http_response_code(400);
			echo json_encode(['error' => "El Paciente paciente no existe"], JSON_PRETTY_PRINT);
		} else {
			echo json_encode($response, JSON_PRETTY_PRINT);
		}
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'POST' && $requestUri === '/tipoDiag/add') {
	try {
		// Registrar un Tipo de Diagnostico
		$data = json_decode(file_get_contents('php://input'), true);
		$tipoDiagnostico = $tipoDiagController->addTipoDiagnostico($data);
		header('Content-Type: application/json');
		echo json_encode(['message' => 'Tipo de Diagnostico creado', 'ID registrado' => $tipoDiagnostico->getId()]);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'POST' && $requestUri === '/diagnostico/add') {
	try {
		// Crear un diagnóstico
		$data = json_decode(file_get_contents('php://input'), true);
		$diagnostico = $diagnosticoController->crearDiagnostico($data);

		header('Content-Type: application/json');
		echo json_encode(['message' => 'Diagnostico creado', 'ID diagnóstico registrado' => $diagnostico->getId()]);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

if ($requestMethod === 'DELETE' && preg_match('#^/diagnostico/([\w-]+)$#', $requestUri, $matches)) {
	try {
		// Eliminar un diagnostico
		$id = $matches[1];
		$diagnosticoController->eliminarDiagnostico($id);
		http_response_code(201);
		echo json_encode(['message' => 'Diagnostico con ID '.$id.' eliminado correctamente']);
	} catch (\Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
	}
	exit;
}

// Ruta no encontrada
http_response_code(404);
echo json_encode(['mensaje' => 'Ruta incorrecta']);
