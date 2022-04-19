<?php

namespace App\Infrastructure\Persistence\Entity;

use App\Application\Product\FindOne\FindOneProductsFactory;
use App\Infrastructure\Persistence\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\PersistentCollection;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Schema]
#[Entity(repositoryClass: ClientRepository::class)]
#[Table(name: "clients")]
class Client implements \JsonSerializable
{
    #[Property(type: "string", default: "1ecbcf2e-511a-6d22-aeb5")]
    #[Id, Column(type: "uuid", unique: true)]
    #[GeneratedValue(strategy: "CUSTOM")]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid $id;

    #[Property(default: "carlos")]
    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $name;

    #[Property(default: "carlos@gmail.com")]
    #[Column(type: Types::STRING, length: 255)]
    #[Email]
    #[NotBlank]
    private string $email;

    #[OneToMany(mappedBy: 'client', targetEntity: Product::class)]
    private PersistentCollection $favoriteProducts;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
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

    public function getFavoriteProducts(): PersistentCollection
    {
        return $this->favoriteProducts;
    }

    public function setFavoriteProducts(PersistentCollection $favoriteProducts): void
    {
        $this->favoriteProducts = $favoriteProducts;
    }

    public function jsonSerialize(): array
    {
        $favoriteProducts = [];
        if (isset($this->favoriteProducts)) {
            $favoriteProducts = $this->favoriteProducts
                ->map(fn ($item) => FindOneProductsFactory::make($item))
                ->toArray();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'favoriteProducts' => $favoriteProducts,
        ];
    }
}
