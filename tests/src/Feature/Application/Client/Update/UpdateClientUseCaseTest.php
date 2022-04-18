<?php

namespace App\Tests\src\Feature\Application\Client\Update;

use App\Application\Client\Update\UpdateClientInputData;
use App\Domain\Entity\Client as ClientDomain;
use App\Application\Client\Update\UpdateClientUseCase;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Exception\ClientNotFoundException;
use App\Infrastructure\Persistence\Repository\ClientRepository;
use App\Tests\src\Utils\DatabaseTestCase;
use Symfony\Component\Uid\Uuid;

class UpdateClientUseCaseTest extends DatabaseTestCase
{

    private ClientRepository $clientRepository;
    private UpdateClientUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepository = new ClientRepository($this->paginator , $this->entityManager);
        $this->useCase = new UpdateClientUseCase($this->clientRepository);
    }

    private function createClient(): Client
    {
        $domain = new ClientDomain(
            name: 'dqdw w',
            email: 'casa@gamil.com'
        );
        return $this->clientRepository->create($domain);
    }

    /** @test  */
    public function shouldUpdateClientName(): void
    {
        $clientCreated = $this->createClient();
        $clientCreatedOldName = $clientCreated->getName();
        $updateInput = new UpdateClientInputData();
        $updateInput->setId($clientCreated->getId());
        $updateInput->setEmail($clientCreated->getEmail());
        $updateInput->setName('carlos');
        $clientUpdated = $this->useCase->update($updateInput);

        self::assertNotEquals($clientCreatedOldName, $clientUpdated->getName());
    }

    /** @test  */
    public function shouldUpdateClientEmail(): void
    {
        $clientCreated = $this->createClient();
        $clientCreatedOldEmail = $clientCreated->getEmail();
        $updateInput = new UpdateClientInputData();
        $updateInput->setId($clientCreated->getId());
        $updateInput->setName($clientCreated->getName());
        $updateInput->setEmail('another@gmail.com');
        $clientUpdated = $this->useCase->update($updateInput);

        self::assertNotEquals($clientCreatedOldEmail, $clientUpdated->getEmail());
    }

    /** @test  */
    public function shouldReturnExceptionIfNotFoundClient(): void
    {
        $uuid = (string) Uuid::v4();
        self::expectException(ClientNotFoundException::class);
        $updateInput = new UpdateClientInputData();
        $updateInput->setId($uuid);
        $updateInput->setName('carlos');
        $updateInput->setEmail('another@gmail.com');
        $this->useCase->update($updateInput);
    }
}
