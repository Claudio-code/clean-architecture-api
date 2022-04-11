<?php

namespace App\Tests\src\Utils\Traits;

use App\Application\Client\Create\CreateClientInputData;
use App\Infrastructure\Persistence\Entity\Client;
use Symfony\Component\Uid\UuidV4;

trait CreateClientMocksTrait
{
    private function createClientInputDataWithAllValidFields(): CreateClientInputData
    {
        $input = CreateClientInputData::makeEmpty();
        return $input->setEmail('teste@gmail.com')
            ->setName('teste');
    }

    private function createClientInputDataWithInvalidName(): CreateClientInputData
    {
        return $this->createClientInputDataWithAllValidFields()
            ->setName('');
    }

    private function createClientInputDataWithInvalidEmail(): CreateClientInputData
    {
        return $this->createClientInputDataWithAllValidFields()
            ->setEmail('dqw1221d.dqd');
    }

    private function createClientPersistenceWithValidFields(): Client
    {
        $client = new Client();
        return $client->setName('teste')
            ->setEmail('teste@gmail.com')
            ->setId(UuidV4::v4());
    }
}