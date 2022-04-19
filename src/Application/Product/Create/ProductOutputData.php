<?php

namespace App\Application\Product\Create;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody]
class ProductOutputData implements \JsonSerializable
{
    #[Property(default: "dqw-dqw-dq-wd-qwf-31-121")]
    public readonly string $id;

    #[Property(default: "carro")]
    public readonly string $title;

    #[Property(default: 12.22)]
    public readonly float $price;

    #[Property(default: "https://www.tecmint.com/wp-content/uploads/2020/07/logo.png")]
    public readonly string $image;

    #[Property(default: 5)]
    public readonly float $reviewScore;


    public function __construct(string $id, string $title, float $price, string $image, float $reviewScore = 0.0)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->image = "http://localhost:8000/uploads/products/$image";
        $this->reviewScore = $reviewScore;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'price' => $this->price,
            'reviewScore' => $this->reviewScore,
        ];
    }
}
