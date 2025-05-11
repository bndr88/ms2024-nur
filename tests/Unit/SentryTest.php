<?php

use PHPUnit\Framework\TestCase;
use Sentry\ClientInterface;
use Sentry\SentrySdk;
use Sentry\State\Hub;

class SentryTest extends TestCase
{
    protected function setUp(): void
    {
        // Inicializa Sentry (puede apuntar a DSN inválido en testing)
        \Sentry\init([
			'dsn' => 'https://9be17d9a71fa8832e84d4400c4498c1f@o4509306343587840.ingest.us.sentry.io/4509306347192320',
        ]);
    }

    public function testCaptureExceptionIsCalled()
    {
        // Mock del ClientInterface
        $mockClient = $this->createMock(ClientInterface::class);

        // Esperamos que captureException sea llamado 1 vez
        $mockClient->expects($this->once())
            ->method('captureException');

        // Crea un nuevo Hub y reemplaza el cliente por el mock
        $hub = new Hub($mockClient);
        SentrySdk::setCurrentHub($hub);

        // Lanza y captura una excepción para probar
        try {
            throw new Exception("Error de prueba");
        } catch (Throwable $e) {
            \Sentry\captureException($e);
        }

		// ✅ Evita que PHPUnit marque el test como "risky"
        restore_error_handler();
        restore_exception_handler();
    }
}
