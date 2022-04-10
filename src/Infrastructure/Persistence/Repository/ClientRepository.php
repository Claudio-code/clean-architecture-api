<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Client as ClientDomain;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Exception\ClientAlreadyExistsInTheDatabaseException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
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

    public function findOneByEmail(string $email): ?Client
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findAllPageable(int $page, int $size): PaginationInterface
    {
        return $this->paginator->paginate($this->findAll(), $page, $size);
    }
}
