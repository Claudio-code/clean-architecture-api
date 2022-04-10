<?php

namespace App\Domain\Entity;

use App\Domain\Common\Email;

class Client
{
    private readonly string $name;
    private readonly Email $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = new Email($email);
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
