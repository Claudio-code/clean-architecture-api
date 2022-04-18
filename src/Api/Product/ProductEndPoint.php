<?php

namespace App\Api\Product;

use App\Application\Product\Create\CreateProductInputDataFactory;
use App\Application\Product\Create\CreateProductUseCase;
use App\Application\Product\Update\UpdateProductInputDataFactory;
use App\Application\Product\Update\UpdateProductUseCase;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response as OpenApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductEndPoint extends AbstractController
{
    private const ROUTE_PATH = '/product';

    #[Post(tags: ["Product"])]
    #[OpenApiResponse(
        response: Response::HTTP_CREATED,
        description: "It route return product created.",
        x: [new JsonContent(ref: "#/components/schemas/ProductOutputData")]
    )]
    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/CreateProductInputData")])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_POST)]
    public function create(Request $request, CreateProductUseCase $useCase): JsonResponse
    {
        $input = CreateProductInputDataFactory::make($request);
        return $this->json($useCase->create($input), Response::HTTP_CREATED);
    }

    #[OpenApiResponse(
        response: Response::HTTP_CREATED,
        description: "It route return product updated.",
        x: [new JsonContent(ref: "#/components/schemas/ProductOutputData")]
    )]
    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/UpdateProductInputData")])]
    #[Put(tags: ["Product"])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_PUT)]
    public function update(Request $request, UpdateProductUseCase $useCase): JsonResponse
    {
        $input = UpdateProductInputDataFactory::make($request);
        return $this->json($useCase->update($input));
    }

    #[Get(tags: ["Product"])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_GET)]
    public function findAll()
    {
    }

    #[Get(tags: ["Product"])]
    #[Route(path: self::ROUTE_PATH . "/{id}", methods: Request::METHOD_GET)]
    public function findOne(string $id)
    {
    }

    #[Delete(tags: ["Product"])]
    #[Route(path: self::ROUTE_PATH . "/{id}", methods: Request::METHOD_DELETE)]
    public function remove(string $id)
    {
    }
}
