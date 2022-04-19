<?php

namespace App\Application\Product\FindAll;

use App\Application\Common\FindAllPageableInputData;
use App\Infrastructure\Persistence\Repository\ProductRepository;

class FindAllProductsUseCase
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function findAll(FindAllPageableInputData $inputData): FindAllProductsOutputData
    {
        $productsPageable = $this->productRepository->findAllPageable(
            page: $inputData->getPage(),
            size: $inputData->getSize()
        );
        return FindAllProductsOutputListFactory::make($productsPageable);
    }
}