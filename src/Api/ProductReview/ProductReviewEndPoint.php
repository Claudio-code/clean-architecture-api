<?php

namespace App\Api\ProductReview;

use App\Application\ProductReview\ProductReviewFactory;
use App\Application\ProductReview\ProductReviewUseCase;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\RequestBody;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductReviewEndPoint extends AbstractController
{
    private const ROUTE_PATH = '/product/review';

    #[Post(tags: ["ProductReview"])]
    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/ProductReviewInputData")])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_POST)]
    public function addReview(Request $request, ProductReviewUseCase $useCase): JsonResponse
    {
        $input = ProductReviewFactory::make($request);
        $useCase->addReview($input);
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
