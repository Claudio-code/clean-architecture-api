<?php

namespace App\Application\Product\FindAll;

use App\Application\Product\Create\ProductOutputData;
use App\Infrastructure\Persistence\Entity\Product;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody]
class FindAllProductsOutputData implements \JsonSerializable
{
    #[Property(default: 1)]
    private int $page;

    #[Property( default: 12)]
    private int $size;

    #[Property(type: "array", items: new Items(ref: "#/components/schemas/ProductOutputData"))]
    private array $items;

    public function __construct(int $page, int $size)
    {
        $this->page = $page;
        $this->size = $size;
    }

    public function addProduct(Product $product): void
    {
        $productOutPut = new ProductOutputData(
            id: $product->getId(),
            title: $product->getTitle(),
            price: $product->getPrice(),
            image: $product->getImage()
        );
        $this->items[] = $productOutPut;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
