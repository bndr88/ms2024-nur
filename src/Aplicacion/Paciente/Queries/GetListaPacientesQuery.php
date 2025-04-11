<?php

namespace Mod2Nur\Aplicacion\Paciente\Queries;

class GetListaPacientesQuery
{
	private string $filtro;

	public function __construct(string $filtro)
	{
		$this->filtro = $filtro;
	}

	public function getFiltroSolicitado(): string
	{
		return $this->filtro;
	}
}
