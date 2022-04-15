<?php

namespace App\Api\Client;

use App\Application\Client\Create\CreateClientInputData;
use App\Application\Client\Create\CreateClientUseCase;
use App\Application\Client\FindAll\FindAllClientInputData;
use App\Application\Client\FindAll\FindAllClientUseCase;
use App\Application\Client\Remove\RemoveClientInputData;
use App\Application\Client\Remove\RemoveClientUseCase;
use App\Application\Client\Update\UpdateClientInputData;
use App\Application\Client\Update\UpdateClientUseCase;
use App\Infrastructure\Form\CreateClientForm;
use App\Infrastructure\Form\UpdateClientForm;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response as OpenApiResponse;
use OpenApi\Attributes\RequestBody;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientEndPoint extends AbstractController
{
    private const ROUTE_PATH = '/client';

    #[Parameter(name: 'page', description: "current page where do all the clients come from.", in: "query")]
    #[Parameter(name: "size", description: "number of clients per page.", in: "query")]
    #[OpenApiResponse(
        response: Response::HTTP_OK,
        description: "It route return all clients.",
        x: [new JsonContent(ref: "#/components/schemas/FindAllClientOutPutData")]
    )]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_GET)]
    public function findAll(Request $request, FindAllClientUseCase $useCase): JsonResponse
    {
        $input = new FindAllClientInputData(
            page: $request->query->get('page'),
            size: $request->query->get('size'),
        );
        return $this->json($useCase->findAll($input));
    }

    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/CreateClientInputData")])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_POST)]
    public function create(Request $request, CreateClientUseCase $useCase): JsonResponse
    {
        $input = CreateClientInputData::makeEmpty();
        $form = $this->createForm(CreateClientForm::class, $input);
        $form->submit($request->request->all());
        return $this->json($useCase->create($input));
    }

    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/Client")])]
    #[OpenApiResponse(
        response: Response::HTTP_OK,
        description: "Return client updated.",
        x: [new JsonContent(ref: "#/components/schemas/Client")]
    )]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_PUT)]
    public function update(Request $request, UpdateClientUseCase $useCase): JsonResponse
    {
        $input = UpdateClientInputData::makeEmpty();
        $form = $this->createForm(UpdateClientForm::class, $input);
        $form->submit($request->request->all());
        return $this->json($useCase->update($input));
    }

    #[Delete(description: "Send client email in url to remove him")]
    #[OpenApiResponse(response: Response::HTTP_NO_CONTENT, description: "Return not content Http code if client is removed.")]
    #[Route(path: self::ROUTE_PATH . "/{email}", methods: Request::METHOD_DELETE)]
    public function remove(string $email, RemoveClientUseCase $useCase): JsonResponse
    {
        $input = new RemoveClientInputData($email);
        $useCase->remove($input);
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
