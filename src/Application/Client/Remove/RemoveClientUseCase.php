<?php

namespace App\Application\Client\Remove;

use App\Domain\Entity\Client\ClientPathAndRemove;
use App\Infrastructure\Persistence\Repository\ClientRepository;

class RemoveClientUseCase
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

    public function remove(RemoveClientInputData $inputData): void
    {
        $domain = $this->toDomain($inputData);
        $this->clientRepository->delete($domain);
    }

    public function toDomain(RemoveClientInputData $inputData): ClientPathAndRemove
    {
        return new ClientPathAndRemove(email: $inputData->getEmail());
    }
}
