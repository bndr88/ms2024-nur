<?php

namespace Mod2Nur\Dominio\Diagnostico;

use DateTime;
use Mod2Nur\Dominio\Abstracciones\Entity;

class AnalisisClinico extends Entity {
    private DateTime $fechaRealizacion;
    private string $observaciones;
    private string $conclusion;
    private bool $estaConcluido = false;

    public function __construct(string $id, DateTime $fechaRealizacion, string $observaciones, string $conclusion) {
        parent::__construct($id);
        $this->fechaRealizacion = $fechaRealizacion;
        $this->observaciones = $observaciones;
        $this->conclusion = $conclusion;
    }

    public function concluirAnalisis(): void {
        $this->estaConcluido = true;
    }

    public function isConcluido(): bool {
        return $this->estaConcluido;
    }
}
