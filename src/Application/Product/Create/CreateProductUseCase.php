<?php

namespace App\Application\Product\Create;

use App\Domain\Entity\Product;
use App\Infrastructure\Persistence\Repository\ProductRepository;

class CreateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly Product $product
    ){
    }

    public function create(CreateProductInputData $inputData): ProductOutputData
    {
        $this->product->setProperties($inputData);
        $this->product->saveImage();
        try {
            $product = $this->productRepository->create($this->product);
            return new ProductOutputData(
                id: $product->getId(),
                title: $product->getTitle(),
                price: $product->getPrice(),
                image: $product->getImage(),
            );
        } catch (\Exception $exception) {
            $this->product->deleteImage();
            throw $exception;
        }
    }
}
