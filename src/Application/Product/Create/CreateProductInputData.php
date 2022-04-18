<?php

namespace App\Application\Product\Create;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[RequestBody]
class CreateProductInputData
{
    #[Property(default: "carro")]
    private string $title;

    #[Property(default: 12.22)]
    private float $price;

    #[Property(
        type: "string",
        default: "https://www.tecmint.com/wp-content/uploads/2020/07/logo.png"
    )]
    private UploadedFile $image;

    #[Property(default: "Gurgel")]
    private string $brand;

    public static function makeEmpty(): self
    {
        return new self();
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

    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    public function setImage(UploadedFile $image): void
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
}
