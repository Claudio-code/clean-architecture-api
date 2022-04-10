<?php

namespace App\Api\Client;

use App\Application\Client\CreateClientInputData;
use App\Application\Client\CreateClientUseCase;
use App\Infrastructure\Form\ClientForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientEndPoint extends AbstractController
{
    #[Route(path: "/client", methods: Request::METHOD_GET)]
    public function findAll(): JsonResponse
    {
        return $this->json('client ok');
    }

    #[Route(path: "/client", methods: Request::METHOD_POST)]
    public function create(Request $request, CreateClientUseCase $useCase): JsonResponse
    {
        $input = CreateClientInputData::makeEmpty();
        $form = $this->createForm(ClientForm::class, $input);
        $form->submit($request->request->all());
        return $this->json($useCase->create($input));
    }
}
