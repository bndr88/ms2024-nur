<?php

namespace Mod2Nur\Infraestructura;

use Illuminate\Database\Capsule\Manager as DB;

class UnitOfWork
{
    private array $newEntities = [];
    private array $updatedEntities = [];
    private array $deletedEntities = [];
    private array $domainEvents = [];

    public function registerNew($entity)
    {
        $this->newEntities[] = $entity;
    }

    public function registerUpdated($entity)
    {
        $this->updatedEntities[] = $entity;
    }

    public function registerDeleted($entity)
    {
        $this->deletedEntities[] = $entity;
    }

    public function registerDomainEvent($event)
    {
        $this->domainEvents[] = $event;
    }

    public function commit()
    {
        DB::transaction(function () {
            foreach ($this->newEntities as $entity) {
                $entity->save();
            }

            foreach ($this->updatedEntities as $entity) {
                $entity->save();
            }

            foreach ($this->deletedEntities as $entity) {
                $entity->delete();
            }

            foreach ($this->domainEvents as $event) {
                // Poner los eventos de dominio
                // Por simplicidad, solo lo  estoy imprimiendo
                echo "Procesando evento de dominio: " . get_class($event) . PHP_EOL;
            }

            $this->clear();
        });
    }

    private function clear()
    {
        $this->newEntities = [];
        $this->updatedEntities = [];
        $this->deletedEntities = [];
        $this->domainEvents = [];
    }
}
