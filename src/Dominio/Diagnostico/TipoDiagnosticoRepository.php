<?php

namespace Mod2Nur\Dominio\Diagnostico;

interface TipoDiagnosticoRepository {
    public function save(TipoDiagnostico $tipoDiagnostico): bool;
    public function findById(string $id): ?TipoDiagnostico; 
    public function remove(string $id): bool;
}