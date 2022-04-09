<?php

namespace App\Api\User;

use App\Application\User\CreateUserInputData;
use App\Application\User\CreateUserUseCase;
use App\Infrastructure\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserEndpoint extends AbstractController
{
    #[Route(path: "/user", methods: Request::METHOD_POST)]
    public function create(Request $request, CreateUserUseCase $useCase): JsonResponse
    {
        $input = CreateUserInputData::makeEmpty();
        $form = $this->createForm(UserForm::class, $input);
        $form->submit($request->request->all());
        $useCase->create($input);
        return $this->json($input->getEmail());
    }
}
