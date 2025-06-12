<?php

namespace Mod2Nur\Infraestructura\RepositoriosEloquent;

use DateTime;
use Mod2Nur\Dominio\Abstracciones\AggregateRoot;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Dominio\Paciente\PacienteRepository;
use Mod2Nur\Infraestructura\Modelos\Paciente as PacienteModel;
use Mod2Nur\Infraestructura\UnitOfWork;

class EloquentPacienteRepository implements PacienteRepository
{
	private ?UnitOfWork $unitOfWork;

	public function __construct(?UnitOfWork $unitOfWork)
	{
		$this->unitOfWork = $unitOfWork;
	}

	public function saveConUnitOfWork(Paciente $paciente)
	{
		$pacienteModel = PacienteModel::find($paciente->getId());
		if (!$pacienteModel) {
			$pacienteModel = new PacienteModel();
			$pacienteModel->id = $paciente->getId();
			$pacienteModel->nombre = $paciente->getNombre();
			$pacienteModel->fechaNacimiento = $paciente->getFechaNacimiento()->format('Y-m-d');
			$this->unitOfWork->registerNew($pacienteModel);
		}
	}

	public function getUnitOfWork(): UnitOfWork
	{
		return $this->unitOfWork;
	}

	public function save(AggregateRoot $aggregateRoot): ?Paciente
	{
		if (!$aggregateRoot instanceof Paciente) {
			throw new \InvalidArgumentException('Expected instance of Paciente');
		}

		$pacienteModel = PacienteModel::find($aggregateRoot->getId());
		if (!$pacienteModel) {
			$pacienteModel = new PacienteModel();
		}

		$pacienteModel->id = $aggregateRoot->getId();
		$pacienteModel->nombre = $aggregateRoot->getNombre();
		$pacienteModel->fechaNacimiento = $aggregateRoot->getFechaNacimiento()->format('Y-m-d');
		if ($pacienteModel->save()) {
			return new Paciente($pacienteModel->id, $pacienteModel->nombre, new DateTime($pacienteModel->fechaNacimiento));
		}
	}

	public function findById(string $id): ?AggregateRoot
	{
		$pacienteModel = PacienteModel::find($id);
		if (!$pacienteModel) {
			return null;
		}

		return new Paciente(
			$pacienteModel->id,
			$pacienteModel->nombre,
			new DateTime($pacienteModel->fechaNacimiento)
		);
	}

	public function delete(string $id): void
	{
		$pacienteModel = PacienteModel::find($id);
		if ($pacienteModel) {
			$pacienteModel->delete();
		}
	}

	public function listarTodos(): array
	{
		$pacienteModel = PacienteModel::all();
		if (!$pacienteModel) {
			return [];
		}

		return $pacienteModel->toArray();
	}

	public function historialClinico(string $idPaciente): array
	{
		// Buscar al paciente por UUID
		$paciente = PacienteModel::where('id', $idPaciente)->first();

		// Si no se encuentra el paciente, devolver un arreglo vacío
		if (!$paciente) {
			return ['error' => 'paciente no existe'];
		}

		// Cargar el historial clínico del paciente usando la relación 'historialClinico'
		$historialClinico = $paciente->historialClinico;

		// Verificamos si el historial clínico tiene datos
		if ($historialClinico->isEmpty()) {
			return [];
		}

		// Retornamos el historial clínico como un arreglo
		return $historialClinico->toArray();
	}
}
