<?php

namespace App\Domain\Entity\Client;

use App\Domain\Common\Email;
use App\Domain\Common\StringValue;

class Client
{
    private ?StringValue $id;
    private readonly StringValue $name;
    private readonly Email $email;

    public function __construct(string $name, string $email, ?string $id = null)
    {
        $this->name = new StringValue($name);
        $this->email = new Email($email);
        $this->id = match (is_null($id)) {
            true => $id,
            default => new StringValue($id),
        };
    }

    public function getId(): ?string
    {
        return $this->id->getValue();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
