<?php

namespace App\Infrastructure\Persistence\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\LockMode;

abstract class AbstractRepository extends ServiceEntityRepository
{
    /** @throws Exception  */
    public function persistWithTransaction(object &$entity): void
    {
        $this->beginTransaction();
        try {
            $this->persist($entity);
        } catch (\Exception $exception) {
            $this->rollBack();
            throw $exception;
        }
        $this->commit();
    }

    public function lock(object $entity): void
    {
        $this->getEntityManager()->lock($entity, LockMode::PESSIMISTIC_READ);
        $this->getEntityManager()->refresh($entity);
    }

    public function remove(object $doctrineEntity): void
    {
        $manager = $this->getEntityManager();
        $manager->remove($doctrineEntity);
        $manager->flush();
    }

    /** @throws Exception */
    public function beginTransaction(): void
    {
        $this->getEntityManager()
            ->getConnection()
            ->beginTransaction();
    }

    /** @throws Exception */
    public function rollBack(): void
    {
        $this->getEntityManager()
            ->getConnection()
            ->rollBack();
    }

    /** @throws Exception */
    public function commit(): void
    {
        $this->getEntityManager()
            ->getConnection()
            ->commit();
    }

    public function persist(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
