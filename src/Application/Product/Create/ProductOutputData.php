<?php

namespace App\Application\Product\Create;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody]
class ProductOutputData
{
    #[Property(default: "dqw-dqw-dq-wd-qwf-31-121")]
    public readonly string $id;

    #[Property(default: "carro")]
    public readonly string $title;

    #[Property(default: 12.22)]
    public readonly float $price;

    #[Property(default: "https://www.tecmint.com/wp-content/uploads/2020/07/logo.png")]
    public readonly string $image;

    public function __construct(string $id, string $title, float $price, string $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->image = $image;
    }
}
