<?php

namespace App\Api\Client;

use App\Application\Client\Create\CreateClientInputData;
use App\Application\Client\Create\CreateClientUseCase;
use App\Application\Client\FindAll\FindAllClientInputData;
use App\Application\Client\FindAll\FindAllClientUseCase;
use App\Application\Client\Update\UpdateClientInputData;
use App\Application\Client\Update\UpdateClientUseCase;
use App\Infrastructure\Form\CreateClientForm;
use App\Infrastructure\Form\UpdateClientForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientEndPoint extends AbstractController
{
    #[Route(path: "/client", methods: Request::METHOD_GET)]
    public function findAll(Request $request, FindAllClientUseCase $useCase): JsonResponse
    {
        $input = new FindAllClientInputData(
            page: $request->query->get('page', 1),
            size: $request->query->get('page', 5),
        );
        return $this->json($useCase->findAll($input));
    }

    #[Route(path: "/client", methods: Request::METHOD_POST)]
    public function create(Request $request, CreateClientUseCase $useCase): JsonResponse
    {
        $input = CreateClientInputData::makeEmpty();
        $form = $this->createForm(CreateClientForm::class, $input);
        $form->submit($request->request->all());
        return $this->json($useCase->create($input));
    }

    #[Route(path: "/client", methods: Request::METHOD_PUT)]
    public function update(Request $request, UpdateClientUseCase $useCase): JsonResponse
    {
        $input = UpdateClientInputData::makeEmpty();
        $form = $this->createForm(UpdateClientForm::class, $input);
        $form->submit($request->request->all());
        return $this->json($useCase->update($input));
    }
}
