<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Commands;

class AddTipoDiagnosticoCommand {
    private string $descripcion;

    public function __construct( string $descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }
}