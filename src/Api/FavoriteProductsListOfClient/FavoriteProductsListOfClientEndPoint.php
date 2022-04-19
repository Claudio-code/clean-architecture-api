<?php

namespace App\Api\FavoriteProductsListOfClient;

use App\Application\FavoriteProductsListOfClient\Add\FavoriteProductsListOfClientInputDataFactory;
use App\Application\FavoriteProductsListOfClient\Add\FavoriteProductsListOfClientUseCase;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\RequestBody;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteProductsListOfClientEndPoint extends AbstractController
{
    private const ROUTE_PATH = '/product/favorite';

    #[Post(tags: ["FavoriteProductsListOfClient"])]
    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/FavoriteProductsListOfClientInputData")])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_POST)]
    public function addProductInList(Request $request, FavoriteProductsListOfClientUseCase $useCase): JsonResponse
    {
        $input = FavoriteProductsListOfClientInputDataFactory::make($request);
        return $this->json($useCase->add($input));
    }

    #[Delete(tags: ["FavoriteProductsListOfClient"])]
    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/FavoriteProductsListOfClientInputData")])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_DELETE)]
    public function removeProductInList(Request $request, FavoriteProductsListOfClientUseCase $useCase): JsonResponse
    {
        $input = FavoriteProductsListOfClientInputDataFactory::make($request);
        return $this->json($useCase->remove($input));
    }
}