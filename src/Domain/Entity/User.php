<?php

namespace App\Domain\Entity;

use App\Application\User\CreateUserInputData;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class User implements PasswordAuthenticatedUserInterface
{
    private string $name;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function setProperties(CreateUserInputData $inputData): void
    {
        $this->setName($inputData->getName());
        $this->setEmail($inputData->getEmail());
        $this->setPassword($inputData->getPassword());
        $this->setRole($inputData->getRole());
    }

    private function setRole($roles): void
    {
        $this->role = match (is_array($roles)) {
            true => implode(',', $roles),
            default => $roles,
        };
    }

    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    private function setPassword(string $password): void
    {
        $this->password = $this->passwordHasher->hashPassword($this, $password);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
