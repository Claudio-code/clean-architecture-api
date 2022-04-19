<?php

namespace App\Application\Product\Remove;

use App\Infrastructure\Persistence\Repository\ProductRepository;

class RemoveProductUseCase
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function remove(string $id): void
    {
        $this->productRepository->delete($id);
    }
}
