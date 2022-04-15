<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Infrastructure\Persistence\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractRepository<Product> */
class ProductRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}
