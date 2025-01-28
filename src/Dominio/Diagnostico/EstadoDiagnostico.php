<?php

namespace Mod2Nur\Dominio\Diagnostico;

enum EstadoDiagnostico: string {
    case PENDIENTE = 'Pendiente';
    case EN_PROCESO = 'En Proceso';
    case CONCLUIDO = 'Concluido';
}
