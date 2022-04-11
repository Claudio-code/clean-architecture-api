<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Client as ClientDomain;
use App\Domain\Entity\ClientPathAndRemove;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Exception\ClientAlreadyExistsInTheDatabaseException;
use App\Infrastructure\Persistence\Exception\ClientNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/** @extends AbstractRepository<Client> */
class ClientRepository extends AbstractRepository
{
    public function __construct(
        private PaginatorInterface $paginator,
        ManagerRegistry $registry
    ) {
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

    public function update(ClientDomain $clientDomain): Client
    {
        /** @var Client $clientFound */
        $clientFound = $this->findOneByEmail($clientDomain->getEmail());
        if (!($clientFound instanceof Client)) {
            return $this->create($clientDomain);
        }
        $clientFound->setName($clientDomain->getName());
        $clientFound->setEmail($clientDomain->getEmail());
        $this->persistWithTransaction($clientFound);
        return $clientFound;
    }

    public function delete(ClientPathAndRemove $clientPathAndRemove): void
    {
        /** @var Client $clientFound */
        $clientFound = $this->findOneByEmail($clientPathAndRemove->getEmail());
        if (!($clientFound instanceof Client)) {
            throw new ClientNotFoundException();
        }
        $this->remove($clientFound);
    }

    public function findOneByEmail(string $email): ?Client
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findAllPageable(int $page, int $size): PaginationInterface
    {
        return $this->paginator->paginate($this->findAll(), $page, $size);
    }
}
