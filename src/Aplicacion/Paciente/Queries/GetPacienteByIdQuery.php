<?php

namespace Mod2Nur\Aplicacion\Paciente\Queries;

class GetPacienteByIdQuery
{
	private string $id;

	public function __construct(string $id)
	{
		$this->id = $id;
	}

	public function getId(): string
	{
		return $this->id;
	}
}
