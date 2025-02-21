<?php

/*use Mod2Nur\Aplicacion\Diagnostico\Handlers\AddDiagnosticoHandler;
use Mod2Nur\Aplicacion\Diagnostico\Commands\AddDiagnosticoCommand;
use Mod2Nur\Infraestructura\UnitOfWork;
use Mockery;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentDiagnosticoRepository;
use Tests\TestCase;

beforeEach(function () {
    // Arrange: Configuración inicial de los mocks y la instancia del handler
    $this->repository = Mockery::mock(EloquentDiagnosticoRepository::class);
    $this->unitOfWork = Mockery::mock(UnitOfWork::class);
    $this->handler = new AddDiagnosticoHandler($this->repository, $this->unitOfWork);
});

it('debería agregar un diagnóstico correctamente', function () {
    // Arrange: Preparar datos y definir expectativas
    $command = new AddDiagnosticoCommand('Paciente1', 'Tipo1', 'Observaciones');

    $this->repository->shouldReceive('guardar')->once()->andReturnTrue();
    $this->unitOfWork->shouldReceive('commit')->once();

    // Act: Ejecutar la acción principal
    $diagnostico = $this->handler->__invoke($command);

    // Assert: Verificar que el resultado es el esperado
    expect($diagnostico)->not->toBeNull();
})->group('diagnostico');

afterEach(function () {
    Mockery::close();
});
*/