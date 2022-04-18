<?php

namespace App\Domain\Entity\Client;

use App\Domain\Common\Email;
use App\Domain\Common\StringValue;

class ClientPathAndRemove
{
    private ?StringValue $id;
    private ?StringValue $name;
    private ?Email $email;

    public function __construct(?string $id = null, ?string $name = null, ?string $email = null)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    private function setId(?string $id): void
    {
        $this->id =  match (is_string($id)) {
            true => new StringValue($id),
            default => $id,
        };
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function setName(?string $name): void
    {
        $this->name =  match (is_string($name)) {
            true => new StringValue($name),
            default => $name,
        };
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    private function setEmail(?string $email): void
    {
        $this->email = match (is_string($email)) {
            true => new Email($email),
            default => $email,
        };
    }
}
