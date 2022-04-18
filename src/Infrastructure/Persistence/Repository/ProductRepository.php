<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Product\Product as ProductDomain;
use App\Infrastructure\Persistence\Entity\Product;
use App\Infrastructure\Persistence\Exception\ProductAlreadyExistsInTheDatabaseException;
use App\Infrastructure\Persistence\Exception\ProductNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractRepository<Product> */
class ProductRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function create(ProductDomain $productDomain): Product
    {
        $productFound = $this->findOneByOneTitle($productDomain->getTitle());
        if ($productFound instanceof Product) {
            throw new ProductAlreadyExistsInTheDatabaseException();
        }
        $product = new Product();
        $product->setTitle($productDomain->getTitle());
        $product->setImage($productDomain->getImage());
        $product->setBrand($productDomain->getBrand());
        $product->setPrice($productDomain->getPrice());
        $this->persistWithTransaction($product);
        return $product;
    }

    public function update(ProductDomain $productDomain): Product
    {
        $productFound = $this->find($productDomain->getId());
        if (!($productFound instanceof Product)) {
            throw new ProductNotFoundException();
        }
        if ($productDomain->getTitle() != $productFound->getTitle()) {
            $productFound->setTitle($productDomain->getTitle());
        }
        if ($productDomain->getBrand() != $productFound->getBrand()) {
            $productFound->setBrand($productDomain->getBrand());
        }
        if ($productDomain->getPrice() != $productFound->getPrice()) {
            $productFound->setPrice($productDomain->getPrice());
        }
        $this->persistWithTransaction($productFound);
        return $productFound;
    }

    public function findOneByOneTitle(string $title): ?Product
    {
        return $this->findOneBy(['title' => $title]);
    }
}
