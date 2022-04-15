<?php

namespace App\Application\Client\Create;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody(required: true)]
class CreateClientInputData
{
    #[Property(default: 'carlos')]
    private string $name;

    #[Property(default: 'carlos@gmail.com')]
    private string $email;

    public static function makeEmpty(): self
    {
        return new self();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
