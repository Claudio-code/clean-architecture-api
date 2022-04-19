<?php

namespace App\Api\Review;

use OpenApi\Attributes\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewEndPoint extends AbstractController
{
    private const ROUTE_PATH = '/product/review';

    #[Post(tags: ["ProductReview"])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_POST)]
    public function addReview()
    {
        return $this->json([]);
    }
}