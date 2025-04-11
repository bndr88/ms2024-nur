<?php

namespace Mod2Nur\Dominio\Paciente;

use Mod2Nur\Dominio\Abstracciones\AggregateRoot;
use Mod2Nur\Dominio\Abstracciones\Repository;
use Mod2Nur\Dominio\Paciente\Paciente;

interface PacienteRepository extends Repository
{
	public function findById(string $id): ?AggregateRoot;
	public function save(AggregateRoot $aggregateRoot): ?AggregateRoot;
	public function delete(string $id): void;
	public function saveConUnitOfWork(Paciente $paciente);
	public function listarTodos(): array;
	public function historialClinico(string $idPaciente): array;
}
