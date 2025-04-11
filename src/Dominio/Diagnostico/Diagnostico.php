<?php

namespace Mod2Nur\Dominio\Diagnostico;

use DateTime;
use DomainException;
use Illuminate\Support\Str;
use Mod2Nur\Dominio\Abstracciones\AggregateRoot;
use InvalidArgumentException;
use Mod2Nur\Dominio\Paciente\Paciente;

class Diagnostico extends AggregateRoot
{
	private Paciente $paciente;
	private DateTime $fecha;
	private float $peso;
	private float $altura;
	private string $descripcion;
	private EstadoDiagnostico $estadoDiagnostico;
	private TipoDiagnostico $tipoDiagnostico;
	private array $analisisSolicitados = [];

	public function __construct(string|null $id, Paciente $paciente, ?DateTime $fecha, float $peso, float $altura, string $descripcion, EstadoDiagnostico $estadoDiagnostico, TipoDiagnostico $tipoDiagnostico)
	{
		if ($id === '') {
			$this->constructorUno($paciente, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnostico);
		} elseif ($id !== null) {
			$this->constructorDos($id, $paciente, $fecha, $peso, $altura, $descripcion, $estadoDiagnostico, $tipoDiagnostico);
		} else {
			throw new InvalidArgumentException("Parámetros no válidos");
		}
	}

	private function constructorUno(Paciente $paciente, ?DateTime $fecha, float $peso, float $altura, string $descripcion, EstadoDiagnostico $estadoDiagnostico, TipoDiagnostico $tipoDiagnostico)
	{
		$id = (string) Str::uuid();
		parent::__construct($id);
		$this->paciente = $paciente;
		$this->fecha = $fecha;
		$this->peso = $peso;
		$this->altura = $altura;
		$this->descripcion = $descripcion;
		$this->estadoDiagnostico = $estadoDiagnostico;
		$this->tipoDiagnostico = $tipoDiagnostico;
	}

	private function constructorDos(string $id, Paciente $paciente, ?DateTime $fecha, float $peso, float $altura, string $descripcion, EstadoDiagnostico $estadoDiagnostico, TipoDiagnostico $tipoDiagnostico)
	{
		parent::__construct($id);
		$this->paciente = $paciente;
		$this->fecha = $fecha;
		$this->peso = $peso;
		$this->altura = $altura;
		$this->descripcion = $descripcion;
		$this->estadoDiagnostico = $estadoDiagnostico;
		$this->tipoDiagnostico = $tipoDiagnostico;
	}

	public function actualizarDiagnostico(float $peso, float $altura, string $descripcion): void
	{
		$this->peso = $peso;
		$this->altura = $altura;
		$this->descripcion = $descripcion;
	}

	public function addAnalisisClinico(AnalisisClinico $analisis): void
	{
		if ($this->estadoDiagnostico === EstadoDiagnostico::CONCLUIDO) {
			throw new DomainException("No se pueden agregar análisis a un diagnóstico concluido.");
		}
		$this->analisisSolicitados[] = $analisis;
	}

	public function removeAnalisisClinico(string $analisisId): void
	{
		$this->analisisSolicitados = array_filter(
			$this->analisisSolicitados,
			fn ($a) => !$a->getId() === $analisisId
		);
	}

	public function concluirDiagnostico(): void
	{
		foreach ($this->analisisSolicitados as $analisis) {
			if (!$analisis->isConcluido()) {
				throw new DomainException("No se puede concluir el diagnóstico si hay análisis pendientes.");
			}
		}
		$this->estadoDiagnostico = EstadoDiagnostico::CONCLUIDO;
	}

	// Getters
	public function getPaciente(): Paciente
	{
		return $this->paciente;
	}

	public function getFecha(): DateTime
	{
		return $this->fecha;
	}

	public function getPeso(): float
	{
		return $this->peso;
	}

	public function getAltura(): float
	{
		return $this->altura;
	}

	public function getDescripcion(): string
	{
		return $this->descripcion;
	}

	public function getEstadoDiagnostico(): EstadoDiagnostico
	{
		return $this->estadoDiagnostico;
	}

	public function getAnalisisSolicitados(): array
	{
		return $this->analisisSolicitados;
	}

	public function getTipoDiagnostico(): TipoDiagnostico
	{
		return $this->tipoDiagnostico;
	}

	// Setters
	public function setPaciente(Paciente $paciente): void
	{
		$this->paciente = $paciente;
	}

	public function setFecha(DateTime $fecha): void
	{
		$this->fecha = $fecha;
	}

	public function setPeso(float $peso): void
	{
		$this->peso = $peso;
	}

	public function setAltura(float $altura): void
	{
		$this->altura = $altura;
	}

	public function setDescripcion(string $descripcion): void
	{
		$this->descripcion = $descripcion;
	}

	public function setEstadoDiagnostico(EstadoDiagnostico $estadoDiagnostico): void
	{
		$this->estadoDiagnostico = $estadoDiagnostico;
	}

	public function setAnalisisSolicitados(array $analisisSolicitados): void
	{
		$this->analisisSolicitados = $analisisSolicitados;
	}

	public function setTipoDiagnostico(TipoDiagnostico $tipoDiagnostico): void
	{
		$this->tipoDiagnostico = $tipoDiagnostico;
	}

}
