<?php

namespace Mod2Nur\Dominio\Entrevista;

use DateTime;
use Mod2Nur\Dominio\Abstracciones\Entity;

class Entrevista extends Entity {
    private DateTime $fechaRealizacion;

    public function __construct(string $id, DateTime $fechaRealizacion) {
        parent::__construct($id);
        $this->fechaRealizacion = $fechaRealizacion;
    }

    public function getFechaRealizacion(): DateTime {
        return $this->fechaRealizacion;
    }
}
