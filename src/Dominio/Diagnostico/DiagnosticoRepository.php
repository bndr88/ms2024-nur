<?php

namespace Mod2Nur\Dominio\Diagnostico;

interface DiagnosticoRepository
{
    public function save(Diagnostico $diagnostico): ?Diagnostico;

    public function findById(string $id): ?Diagnostico;

    public function delete(string $id): void;
}