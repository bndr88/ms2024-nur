<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mod2Nur\Infraestructura\UnitOfWork;
use Illuminate\Database\Capsule\Manager as DB;
use Mod2Nur\Dominio\Abstracciones\Entity;

class UnitOfWorkTest extends TestCase
{
    private $entityMock;
    private $unitOfWork;

    protected function setUp(): void
    {
        $this->entityMock = $this->createMock(Entity::class);
        $this->unitOfWork = new UnitOfWork();
    }

    public function testSetNuevaEntidad()
    {
        $this->unitOfWork->registerNew($this->entityMock);
        $this->unitOfWork->registerUpdated($this->entityMock);
        $this->unitOfWork->registerDeleted($this->entityMock);
        $this->unitOfWork->registerDomainEvent($this->entityMock);

        $this->assertContains($this->entityMock,$this->unitOfWork->getNewEntities());
        $this->assertContains($this->entityMock,$this->unitOfWork->getUpdatedEntities());
        $this->assertContains($this->entityMock,$this->unitOfWork->getDeletedEntities());
        $this->assertContains($this->entityMock,$this->unitOfWork->getDomainEvents());
    }

  /*  


    public function testCommitExecutesDatabaseTransaction()
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(function ($callback) {
            $callback();
        });

        $entity = $this->createMock(Entity::class);
        $entity->expects($this->once())->method('save');

        $this->unitOfWork->registerNew($entity);
        $this->unitOfWork->commit();
    }

    public function testCommitRemovesDeletedEntities()
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(function ($callback) {
            $callback();
        });

        $entity = $this->createMock(Entity::class);
        $entity->expects($this->once())->method('delete');

        $this->unitOfWork->registerDeleted($entity);
        $this->unitOfWork->commit();
    }

 /*   public function testClearEmptiesAllCollections()
    {
        $entity = $this->createMock(Entity::class);
        $this->unitOfWork->registerNew($entity);
        $this->unitOfWork->registerUpdated($entity);
        $this->unitOfWork->registerDeleted($entity);
        $this->unitOfWork->registerDomainEvent($entity);

        $this->unitOfWork->clear();

        $this->assertEmpty($this->getPrivateProperty($this->unitOfWork, 'newEntities'));
        $this->assertEmpty($this->getPrivateProperty($this->unitOfWork, 'updatedEntities'));
        $this->assertEmpty($this->getPrivateProperty($this->unitOfWork, 'deletedEntities'));
        $this->assertEmpty($this->getPrivateProperty($this->unitOfWork, 'domainEvents'));
    }*/

 /*   private function getPrivateProperty($object, $propertyName)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }*/
}
