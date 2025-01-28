<?php

namespace Mod2Nur\Dominio\Paciente;

use DateTime;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Mod2Nur\Dominio\Abstracciones\AggregateRoot;
use Mod2Nur\Dominio\Abstracciones\Entity;
use Mod2Nur\Dominio\Diagnostico\Diagnostico;
use Mod2Nur\Dominio\Entrevista\Entrevista;

class Paciente extends AggregateRoot {
    private string $nombre;
    private DateTime $fechaNacimiento;
    private array $historial = [];
    private array $entrevistas = [];

    public function __construct(string $id, string $nombre, DateTime $fechaNacimiento) {
        if ($id ==='' && $nombre !== null && $fechaNacimiento !== null) {
            $this->constructorUno($nombre, $fechaNacimiento);
        } elseif ($id !== null) {
            $this->constructorDos($id, $nombre, $fechaNacimiento);
        } else {
            throw new InvalidArgumentException("Parámetros no válidos");
        }
    }

    private function constructorUno(string $nombre, DateTime $fechaNacimiento) {
        $id = (string) Str::uuid();
        parent::__construct($id);
        $this->nombre = $nombre;
        $this->fechaNacimiento = $fechaNacimiento;
    }

    private function constructorDos(string $id, string $nombre, DateTime $fechaNacimiento) {
        parent::__construct($id);
        $this->nombre = $nombre;
        $this->fechaNacimiento = $fechaNacimiento;
    }

     // Getters
     public function getNombre(): string
     {
         return $this->nombre;
     }
 
     public function getFechaNacimiento(): DateTime
     {
         return $this->fechaNacimiento;
     }
 
     public function getHistorial(): array
     {
         return $this->historial;
     }
 
     public function getEntrevistas(): array
     {
         return $this->entrevistas;
     }
 
     // Setters
     public function setNombre(string $nombre): void
     {
         $this->nombre = $nombre;
     }
 
     public function setFechaNacimiento(DateTime $fechaNacimiento): void
     {
         $this->fechaNacimiento = $fechaNacimiento;
     }
 
     public function setHistorial(array $historial): void
     {
         $this->historial = $historial;
     }
 
     public function setEntrevistas(array $entrevistas): void
     {
         $this->entrevistas = $entrevistas;
     }
 
    public function addDiagnostico(Diagnostico $diagnostico): void {
        $this->historial[] = $diagnostico;
    }

    public function removeDiagnostico(string $diagnosticoId): void {
        $this->historial = array_filter(
            $this->historial,
            fn($d) => !$d->getId()->equals($diagnosticoId)
        );
    }

    public function addEntrevista(Entrevista $entrevista): void {
        $this->entrevistas[] = $entrevista;
    }

    public function getDiagnosticos(): array {
        return $this->historial;
    }
}
