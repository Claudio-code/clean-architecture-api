<?php

namespace App\Application\Product\FindOne;

use App\Application\Product\Create\ProductOutputData;
use App\Infrastructure\Persistence\Repository\ProductRepository;

class FindOneProductsUseCase
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function findOne(string $id): ProductOutputData
    {
        $product = $this->productRepository->find($id);
        return FindOneProductsFactory::make($product);
    }
}
