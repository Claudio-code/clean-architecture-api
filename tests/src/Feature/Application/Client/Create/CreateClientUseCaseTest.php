<?php

namespace App\Tests\src\Feature\Application\Client\Create;

use App\Application\Client\Create\CreateClientUseCase;
use App\Domain\Exception\EmptyValueException;
use App\Domain\Exception\InvalidEmailException;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Repository\ClientRepository;
use App\Tests\src\Utils\Traits\CreateClientMocksTrait;
use PHPUnit\Framework\TestCase;


class CreateClientUseCaseTest extends TestCase
{
    use CreateClientMocksTrait;

    private $clientRepository;
    private CreateClientUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepository = \Mockery::mock(ClientRepository::class);
        $this->useCase = new CreateClientUseCase($this->clientRepository);
    }

    /** @test */
    public function shouldSaveNewClient(): void
    {
        $input = $this->createClientInputDataWithAllValidFields();
        $this->clientRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($this->createClientPersistenceWithValidFields());
        $result = $this->useCase->create($input);

        self::assertInstanceOf(Client::class, $result);
    }

    /** @test */
    public function shouldReturnExceptionIfEmailIsInvalid(): void
    {
        self::expectException(InvalidEmailException::class);
        $input = $this->createClientInputDataWithInvalidEmail();
        $this->useCase->create($input);
    }

    /** @test */
    public function shouldReturnExceptionIfNameisEmpty(): void
    {
        self::expectException(EmptyValueException::class);
        $input = $this->createClientInputDataWithInvalidName();
        $this->useCase->create($input);
    }
}
