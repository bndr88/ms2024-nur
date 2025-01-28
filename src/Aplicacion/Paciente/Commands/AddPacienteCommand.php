<?php

namespace Mod2Nur\Aplicacion\Paciente\Commands;

use DateTime;
use Exception;

class AddPacienteCommand
{
    public string $nombre;
    public DateTime $fechaNacimiento;

    public function __construct(string $nombre, string|DateTime $fechaNacimiento)
    {
        $this->nombre = $nombre;
        if (is_string($fechaNacimiento)) {
            try {
                $this->fechaNacimiento = new DateTime($fechaNacimiento);
            } catch (Exception $e) {
                throw new Exception("Formato de fecha inválido: " . $e->getMessage());
            }
        } else {
            $this->fechaNacimiento = $fechaNacimiento;
        }
    }
}