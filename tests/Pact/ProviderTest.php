<?php

use PhpPact\Standalone\ProviderVerifier\Verifier;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Model\ProviderTransport;
use PhpPact\Standalone\ProviderVerifier\Model\PublishOptions;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Uri;

class ProviderTest extends TestCase
{
    protected function setUp(): void
    {
        // Aquí podrías iniciar tu API de pruebas si es necesario
    }

    protected function tearDown(): void
    {
        // Aquí podrías detener la API de pruebas si es necesario
    }

    public function testPactVerifyConsumers(): void
    {
        $config = new VerifierConfig();
        $config->getProviderInfo()
            ->setName('Backend') // Nombre del proveedor
            ->setHost('localhost') // Host donde corre el backend
            ->setPort(8000); // Puerto del backend

        // Ajustar nivel de logs según el entorno
        if ($logLevel = getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        // Crear verificador y ejecutar prueba
        $verifier = new Verifier($config);
        $verifier->addFile(__DIR__ . '/contracts/Frontend-Backend.json');
        $verifyResult = $verifier->verify();

        $this->assertTrue($verifyResult);
    }
}
