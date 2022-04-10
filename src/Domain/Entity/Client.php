<?php

namespace App\Domain\Entity;

use App\Domain\Common\Email;
use App\Domain\Common\StringValue;

class Client
{
    private readonly StringValue $name;
    private readonly Email $email;

    public function __construct(string $name, string $email)
    {
        $this->name = new StringValue($name);
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
