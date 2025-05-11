<?php

namespace Mod2Nur\Presentacion;

use Exception;
use Throwable;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../env.php';
require_once __DIR__ . '/mediator.php';
require_once __DIR__ . '/Rutas.php';
echo "Rutas.php correctamente";

//SENTRY:
require_once __DIR__ . '/sentry.php';

// Captura errores no manejados
set_exception_handler(function (Throwable $e) {
    \Sentry\captureException($e);
    // También puedes loguear o mostrar mensaje amigable
    http_response_code(500);
    echo "Ha ocurrido un error inesperado.";
});

set_error_handler(function ($severity, $message, $file, $line) {
    // Convierte errores en excepciones (para que Sentry los detecte)
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        \Sentry\captureMessage("Error fatal: {$error['message']} en {$error['file']}:{$error['line']}");
    }
});

// Código de prueba para enviar un error
/*try {
  $this->functionFailsForSure();
} catch (Throwable $exception) {
  \Sentry\captureException($exception);
}*/
