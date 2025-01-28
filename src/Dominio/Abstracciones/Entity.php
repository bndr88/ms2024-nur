<?php

namespace Mod2Nur\Dominio\Abstracciones;

abstract class Entity {
    protected string  $id;

    public function __construct(string $id) {
        $this->id = $id;
    }

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function equals(Entity $other): bool {
        return $this->id === $other->getId();
    }
}
