<?php

namespace App\Infrastructure\Persistence\Entity;

use App\Infrastructure\Persistence\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private int $id;

    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $name;

    #[Column(type: Types::STRING, length: 255)]
    #[Email]
    #[NotBlank]
    private string $email;

    #[Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $created_at;

    #[Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $updated_at;

    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $password;

    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $roles;

    public function __construct()
    {
        if (empty($this->created_at)) {
            $this->created_at = new DateTime('now');
        }
        $this->updated_at = new DateTime('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeInterface $updated_at): User
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return match (is_string($this->roles)) {
            true => explode(',', $this->roles),
            default => $this->roles,
        };
    }

    public function setRoles($roles): User
    {
        $this->roles = match (is_array($roles)) {
            true => implode(',', $roles),
            default => $roles,
        };
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
