<?php

namespace Mod2Nur\Aplicacion\Paciente\Servicios;

use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Dominio\Paciente\PacienteCreadoEvent;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;

class CrearPacienteService
{
	private EloquentPacienteRepository $repositorio;

	public function __construct(EloquentPacienteRepository $repositorio)
	{
		$this->repositorio = $repositorio;
	}

	public function ejecutar(Paciente $paciente)
	{
		//$paciente = new Paciente($datosPaciente);
		$this->repositorio->saveConUnitOfWork($paciente);

		// Registrar evento de dominio
		$event = new PacienteCreadoEvent($paciente->getId());
		$this->repositorio->getUnitOfWork()->registerDomainEvent($event);
	}
}
