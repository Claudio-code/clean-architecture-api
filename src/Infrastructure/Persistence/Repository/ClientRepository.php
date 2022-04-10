<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Client as ClientDomain;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Exception\ClientAlreadyExistsInTheDatabaseException;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractRepository<Client> */
class ClientRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function create(ClientDomain $clientDomain): Client
    {
        $clientFound = $this->findOneByEmail($clientDomain->getEmail());
        if ($clientFound instanceof Client) {
            throw new ClientAlreadyExistsInTheDatabaseException();
        }
        $client = new Client();
        $client->setName($clientDomain->getName());
        $client->setEmail($clientDomain->getEmail());
        $this->persistWithTransaction($client);
        return $client;
    }

    public function findOneByEmail(string $email): ?Client
    {
        return $this->findOneBy(['email' => $email]);
    }
}
