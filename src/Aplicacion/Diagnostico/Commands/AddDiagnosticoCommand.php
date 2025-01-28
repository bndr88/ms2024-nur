<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Commands;

use DateTime;
use Exception;
use Mod2Nur\Dominio\Diagnostico\EstadoDiagnostico;
use Mod2Nur\Dominio\Diagnostico\TipoDiagnostico;

class AddDiagnosticoCommand
{
    public string $pacienteId;
    public float $peso;
    public float $altura;
    public string $composicion;
    public string $estadoDiagnostico;
    public string $tipoDiagnosticoId;
    public DateTime $fechaDiagnostico;

    public function __construct(
        string $pacienteId,
        float $peso,
        float $altura,
        string $composicion,
        string $estadoDiagnostico,
        string $tipoDiagnosticoId,
        string|DateTime $fechaDiagnostico
    ) {
        $this->pacienteId = $pacienteId;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->composicion = $composicion;
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
