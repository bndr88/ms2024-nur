<?php

use Mod2Nur\Infraestructura\Modelos\Paciente;
use Illuminate\Support\Str;

require_once __DIR__ . '/../../env.php';

$paciente = new Paciente();
$paciente->id = (string) Str::uuid();
$paciente->nombre = 'El juancho';
$paciente->fechaNacimiento = '1990-01-01';
$paciente->save();

echo "Paciente guardado exitosamente.";