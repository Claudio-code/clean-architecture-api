<?php

namespace App\Domain\Entity\Product;

use App\Application\Product\Create\CreateProductInputData;
use App\Application\Product\Update\UpdateProductInputData;
use App\Domain\Common\Price;
use App\Domain\Common\StringValue;
use App\Domain\Common\UploadFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Product
{
    private const IMAGE_EXTENSIONS = ['png'];
    private const IMAGE_DIRECTORY_SHORTCUT = 'product_dir';

    private ?StringValue $id;
    private StringValue $title;
    private Price $price;
    private UploadedFile $image;
    private string $imageName;
    private StringValue $brand;

    public function __construct(private readonly UploadFile $uploadFile)
    {
    }

    public function setProperties(CreateProductInputData|UpdateProductInputData $inputData): void
    {
        if ($inputData instanceof UpdateProductInputData) {
            $this->id = new StringValue($inputData->getId());
        } else {
            $this->image = $inputData->getImage();
        }

        $this->title = new StringValue($inputData->getTitle());
        $this->price = new Price($inputData->getPrice());
        $this->brand = new StringValue($inputData->getBrand());
    }

    public function saveImage(): void
    {
        $this->imageName = $this->uploadFile
            ->setAllowedFiles(self::IMAGE_EXTENSIONS)
            ->setDirectory(self::IMAGE_DIRECTORY_SHORTCUT)
            ->save($this->image);
    }

    public function deleteImage(): void
    {
        $this->uploadFile->delete($this->imageName);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price->getValue();
    }

    public function getImage(): string
    {
        return $this->imageName;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getId(): ?string
    {
        return $this->id?->getValue();
    }
}
