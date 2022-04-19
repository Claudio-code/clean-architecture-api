<?php

namespace App\Api\Product;

use App\Application\Common\FindAllPageableInputData;
use App\Application\Product\Create\CreateProductInputDataFactory;
use App\Application\Product\Create\CreateProductUseCase;
use App\Application\Product\FindAll\FindAllProductsUseCase;
use App\Application\Product\Update\UpdateProductInputDataFactory;
use App\Application\Product\Update\UpdateProductUseCase;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
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

    #[Parameter(name: 'page', description: "current page where do all the products come from.", in: "query")]
    #[Parameter(name: "size", description: "number of products per page.", in: "query")]
    #[Get(tags: ["Product"])]
    #[OpenApiResponse(
        response: Response::HTTP_CREATED,
        description: "It route return products pageable.",
        x: [new JsonContent(ref: "#/components/schemas/FindAllProductsOutputData")]
    )]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_GET)]
    public function findAll(Request $request, FindAllProductsUseCase $useCase): JsonResponse
    {
        $input = new FindAllPageableInputData(
            page: $request->query->get('page'),
            size: $request->query->get('size'),
        );
        return $this->json($useCase->findAll($input));
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
