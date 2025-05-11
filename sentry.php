<?php
// sentry.php

require_once __DIR__ . '/vendor/autoload.php';

\Sentry\init([
    //'dsn' => 'https://<PUBLIC_KEY>@<HOST>/<PROJECT_ID>',
	'dsn' => 'https://9be17d9a71fa8832e84d4400c4498c1f@o4509306343587840.ingest.us.sentry.io/4509306347192320',
    'environment' => 'production',
    'release' => 'mi-proyecto@1.0.0',
    'error_types' => E_ALL, // captura todos los errores
]);
