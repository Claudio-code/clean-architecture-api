<?php

namespace App\Application\Product\FindOne;

use App\Application\Product\Create\ProductOutputData;
use App\Infrastructure\Persistence\Entity\Product;

class FindOneProductsFactory
{
    public static function make(Product $product): ProductOutputData
    {
        return new ProductOutputData(
            id: $product->getId(),
            title: $product->getTitle(),
            price: $product->getPrice(),
            image: $product->getImage(),
        );
    }
}
