<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Product as ProductDomain;
use App\Infrastructure\Persistence\Entity\Product;
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
        $product = new Product();
        $product->setTitle($productDomain->getTitle());
        $product->setImage($productDomain->getImage());
        $product->setBrand($productDomain->getBrand());
        $product->setPrice($productDomain->getPrice());
        $this->persistWithTransaction($product);
        return $product;
    }
}
