<?php

namespace App\Application\Client\Update;

use App\Domain\Entity\Client as ClientDomain;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Repository\ClientRepository;

class UpdateClientUseCase
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

    public function update(UpdateClientInputData $inputData): Client
    {
        $domain = $this->toDomain($inputData);
        return $this->clientRepository->update($domain);
    }

    private function toDomain(UpdateClientInputData $inputData): ClientDomain
    {
        return new ClientDomain(
            name: $inputData->getName(),
            email: $inputData->getEmail(),
            id: $inputData->getId(),
        );
    }
}
