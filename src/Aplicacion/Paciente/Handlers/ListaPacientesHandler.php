<?php

namespace Mod2Nur\Aplicacion\Paciente\Handlers;

use Mod2Nur\Aplicacion\Paciente\Queries\GetListaPacientesQuery;
use Mod2Nur\Dominio\Paciente\PacienteRepository;

class ListaPacientesHandler
{
	private PacienteRepository $pacienteRepository;

	public function __construct(PacienteRepository $pacienteRepository)
	{
		$this->pacienteRepository = $pacienteRepository;
	}

	public function __invoke(GetListaPacientesQuery $query)
	{
		if (empty($query->getFiltroSolicitado())) {
			$lista = $this->pacienteRepository->listarTodos();
		}
		/*
		//Cuando hayan filtros
		if (!$paciente) {
			throw new \Exception("Paciente no encontrado");
		}*/

		return $lista;
	}
}
