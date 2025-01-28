<?php

namespace Mod2Nur\Dominio\Abstracciones;

interface Repository
{
    public function findById(string $id): ?AggregateRoot;
    public function save(AggregateRoot $aggregateRoot): ?AggregateRoot;
    public function delete(string $id): void;
}
