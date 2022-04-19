<?php

namespace App\Infrastructure\Persistence\Entity;

use App\Infrastructure\Persistence\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity(repositoryClass: ProductRepository::class)]
#[Table(name: "products")]
class Product
{
    #[Id, Column(type: "uuid", unique: true)]
    #[GeneratedValue(strategy: "CUSTOM")]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid $id;

    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $title;

    #[Column(type: Types::FLOAT)]
    #[NotBlank]
    private float $price;

    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $image;

    #[Column(type: Types::STRING, length: 255)]
    #[NotBlank]
    private string $brand;

    #[Column(type: Types::FLOAT, nullable: true)]
    #[NotBlank]
    private float $reviewScore;

    #[Column(type: Types::ARRAY, nullable: true)]
    #[NotBlank]
    private array $review = [];

    #[ManyToOne(targetEntity: Client::class, inversedBy: 'product')]
    private ?Client $client;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getReviewScore(): float
    {
        return $this->reviewScore;
    }

    public function setReviewScore(float $reviewScore): void
    {
        $this->reviewScore = $reviewScore;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }

    public function getReview(): array
    {
        return $this->review;
    }

    public function setReview(array $review): void
    {
        $this->review = $review;
    }
}
