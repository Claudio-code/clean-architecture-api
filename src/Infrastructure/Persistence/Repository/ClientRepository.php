<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Infrastructure\Persistence\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractRepository<Client> */
class ClientRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }
}
