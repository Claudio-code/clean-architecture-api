<?php

namespace App\Application\FavoriteProductsListOfClient\Add;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody]
class FavoriteProductsListOfClientInputData
{
    #[Property(default: "test@gmail.com")]
    private string $clientEmail;

    #[Property(default: "1e12e12-e1e1e")]
    private string $productId;

    public static function makeEmpty(): self
    {
        return new self();
    }

    public function getClientEmail(): string
    {
        return $this->clientEmail;
    }

    public function setClientEmail(string $clientEmail): void
    {
        $this->clientEmail = $clientEmail;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }
}
