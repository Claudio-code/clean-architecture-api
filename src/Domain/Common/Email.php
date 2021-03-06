<?php

namespace App\Domain\Common;

use App\Domain\Exception\InvalidEmailException;

class Email implements \Stringable
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $this->setEmail($email);
    }

    private function setEmail(string $email): string
    {
        return match (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            true => $email,
            default => throw new InvalidEmailException(),
        };
    }

    public function __toString(): string
    {
        return $this->email;
    }
}