<?php

namespace App\Application\Client\Create;

use App\Domain\Entity\Client as ClientDomain;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Repository\ClientRepository;

class CreateClientUseCase
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

    public function create(CreateClientInputData $inputData): Client
    {
        $domain = $this->toDocument($inputData);
        return $this->clientRepository->create($domain);
    }

    private function toDocument(CreateClientInputData $inputData): ClientDomain
    {
        return new ClientDomain(
            name: $inputData->getName(),
            email: $inputData->getEmail(),
        );
    }
}
