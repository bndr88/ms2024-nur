<?php

namespace Mod2Nur\Dominio\Diagnostico;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Mod2Nur\Dominio\Abstracciones\Entity;

class TipoDiagnostico extends Entity {
    private string $descripcion;

    public function __construct(string $id, string $descripcion) {
        if ($id ==='') {
            $this->constructorUno($descripcion);
        } elseif ($id !== null) {
            $this->constructorDos($id, $descripcion);
        } else {
            throw new InvalidArgumentException("Parámetros no válidos");
        }
    }

    private function constructorUno(string $descripcion) {
        $id = (string) Str::uuid();
        parent::__construct($id);
        $this->descripcion = $descripcion;
    }

    private function constructorDos(string $id, string $descripcion) {
        parent::__construct($id);
        $this->descripcion = $descripcion;
    }

    // Getters
    public function getDescripcion(): string {
        return $this->descripcion;
    }

    // Setters
    public function setDescripcion(float $descripcion): void {
        $this->descripcion = $descripcion;
    }
}
