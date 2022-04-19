<?php

namespace App\Application\ProductReview;

use App\Infrastructure\Persistence\Entity\Product;
use App\Infrastructure\Persistence\Exception\ProductNotFoundException;
use App\Infrastructure\Persistence\Repository\ClientRepository;
use App\Infrastructure\Persistence\Repository\ProductRepository;

class ProductReviewUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ClientRepository $clientRepository,
    ) {
    }

    public function addReview(ProductReviewInputData $inputData): void
    {
        /** @var Product $product */
        $product = $this->productRepository->find($inputData->getProductId());
        if (!($product instanceof Product)) {
            throw new ProductNotFoundException();
        }
        $this->clientRepository->findOneByEmail($inputData->getClientEmail());

        if (empty($product->getReview())) {
            $product->addReview($inputData->getReview());
            $product->setReviewScore($inputData->getReview());
            $this->productRepository->persistWithTransaction($product);
            return;
        }

        $product->addReview($inputData->getReview());
        $allReviews = $product->getReview();

        arsort($allReviews);
        $length = count($allReviews);
        $half_length = $length / 2;
        $median_index = (int) $half_length;

        $median = $allReviews[$median_index];
        $product->setReviewScore($median);
        $this->productRepository->persistWithTransaction($product);
    }
}
