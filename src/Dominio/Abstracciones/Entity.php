<?php

namespace Mod2Nur\Dominio\Abstracciones;

use InvalidArgumentException;
use PHPUnit\Framework\Constraint\IsEmpty;

abstract class Entity {
    protected string  $id;

    public function __construct(string $id) {
        if (empty($id)) {
            throw new InvalidArgumentException('El ID proporcionado no puede estar vacío.');
        }
        if (!$this->esUuidValido($id)) {
            throw new InvalidArgumentException('El ID proporcionado no tiene un formato UUID válido.');
        }        
        $this->id = $id;
    }

    private function esUuidValido(string $id): bool
{
    $uuidRegex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
    return preg_match($uuidRegex, $id) === 1;
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
