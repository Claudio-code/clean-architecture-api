<?php

namespace App\Domain\Entity\FavoriteProductsListOfClient;

use App\Application\FavoriteProductsListOfClient\Add\FavoriteProductsListOfClientInputData;
use App\Application\Product\FindOne\FindOneProductsFactory;
use App\Infrastructure\Persistence\Entity\Client;
use App\Infrastructure\Persistence\Entity\Product;
use App\Infrastructure\Persistence\Repository\ClientRepository;
use App\Infrastructure\Persistence\Repository\ProductRepository;
use Doctrine\ORM\PersistentCollection;

class FavoriteProductsListOfClient
{
    private PersistentCollection $favoriteProductsList;

    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly ProductRepository $productRepository,
    ) {
    }

    private function findClient(FavoriteProductsListOfClientInputData $inputData): Client
    {
        /** @var Client $client */
        $client = $this->clientRepository->findOneByEmail($inputData->getClientEmail());
        $this->favoriteProductsList = $client->getFavoriteProducts();
        return $client;
    }

    private function findProductInList(Product $productToFind)
    {
        return $this->favoriteProductsList
            ->filter(fn (Product $product) => $product->getId()->equals($productToFind->getId()))
            ?->first();
    }

    public function add(FavoriteProductsListOfClientInputData $inputData): array
    {
        /** @var Product $productToAdd */
        $productToAdd = $this->productRepository->find($inputData->getProductId());
        $client = $this->findClient($inputData);
        $productFiltered = $this->findProductInList($productToAdd);

        if (!empty($productFiltered)) {;
            return $this->formatterResponseCollection();
        }

        $productToAdd->setClient($client);
        $this->favoriteProductsList->add($productToAdd);
        $this->clientRepository->updateFavoriteList($this->favoriteProductsList, $client);
        return $this->formatterResponseCollection();
    }

    public function remove(FavoriteProductsListOfClientInputData $inputData): array
    {
        /** @var Product $productToRemove */
        $productToRemove = $this->productRepository->find($inputData->getProductId());
        $client = $this->findClient($inputData);
        $productToRemoveFitted = $this->favoriteProductsList
            ->filter(fn (Product $product) => $product->getId()->equals($productToRemove->getId()));
        $this->favoriteProductsList->remove($productToRemoveFitted->key());
        $productToRemoveClient = $productToRemoveFitted->first();

        if ($productToRemoveClient instanceof Product) {
            $productToRemoveClient->setClient(null);
            $this->productRepository->persistWithTransaction($productToRemoveClient);
        }

        $this->clientRepository->updateFavoriteList($this->favoriteProductsList, $client);
        return $this->formatterResponseCollection();
    }


    public function formatterResponseCollection(): array
    {
        return $this->favoriteProductsList
            ->map(FindOneProductsFactory::make(...))
            ->toArray();
    }
}
