<?php

namespace App\Application\Product\Create;

use App\Application\Product\FindOne\FindOneProductsFactory;
use App\Domain\Entity\Product\Product;
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
            return FindOneProductsFactory::make($product);
        } catch (\Exception $exception) {
            $this->product->deleteImage();
            throw $exception;
        }
    }
}
