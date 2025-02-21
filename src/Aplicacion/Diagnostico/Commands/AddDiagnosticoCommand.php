<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Commands;

use DateTime;
use Exception;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;

class AddDiagnosticoCommand
{
    public string $pacienteId;
    public DateTime $fechaDiagnostico;
    public float $peso;
    public float $altura;
    public string $descripcion;
    public string $estadoDiagnostico;
    public string $tipoDiagnosticoId;

    public function __construct(
        string $pacienteId,
        string|DateTime $fechaDiagnostico,
        float $peso,
        float $altura,
        string $descripcion,
        string $estadoDiagnostico,
        string $tipoDiagnosticoId
    ) {
        $this->pacienteId = $pacienteId;        
        $this->fechaDiagnostico = $fechaDiagnostico;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->descripcion = $descripcion;
        $this->estadoDiagnostico = $estadoDiagnostico;
        $this->tipoDiagnosticoId = $tipoDiagnosticoId;

        if (is_string($fechaDiagnostico)) {
            try {
                $this->fechaDiagnostico = new DateTime($fechaDiagnostico);
            } catch (Exception $e) {
                throw new Exception("Invalid date format for fechaDiagnostico.");
            }
        } else {
            $this->fechaDiagnostico = $fechaDiagnostico;
        }
    }
}
