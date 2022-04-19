<?php

namespace App\Application\FavoriteProductsListOfClient\Add;

use App\Domain\Entity\FavoriteProductsListOfClient\FavoriteProductsListOfClient;

class FavoriteProductsListOfClientUseCase
{
    public function __construct(private readonly FavoriteProductsListOfClient $favoriteProductsListOfClient)
    {
    }

    public function add(FavoriteProductsListOfClientInputData $inputData): array
    {
        return $this->favoriteProductsListOfClient->add($inputData);
    }

    public function remove(FavoriteProductsListOfClientInputData $inputData): array
    {
        return $this->favoriteProductsListOfClient->remove($inputData);
    }
}
