<?php

namespace Mod2Nur\Presentacion;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../env.php';
require_once __DIR__ . '/mediator.php';
require_once __DIR__ . '/Rutas.php';
echo "Rutas.php correctamente";

//SENTRY:
require_once __DIR__ . '/sentry.php';
// Código de prueba para enviar un error
/*try {
  $this->functionFailsForSure();
} catch (Throwable $exception) {
  \Sentry\captureException($exception);
}*/
