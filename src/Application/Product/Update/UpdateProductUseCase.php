<?php

namespace App\Application\Product\Update;

use App\Application\Product\Create\ProductOutputData;
use App\Domain\Entity\Product\Product;
use App\Infrastructure\Persistence\Repository\ProductRepository;

class UpdateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly Product $product
    ){
    }

    public function update(UpdateProductInputData $inputData): ProductOutputData
    {
        $this->product->setProperties($inputData);
        $productUpdated = $this->productRepository->update($this->product);
        return new ProductOutputData(
            id: $productUpdated->getId(),
            title: $productUpdated->getTitle(),
            price: $productUpdated->getPrice(),
            image: $productUpdated->getImage(),
        );
    }
}
