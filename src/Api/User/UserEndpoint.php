<?php

namespace App\Api\User;

use App\Application\User\CreateUserInputData;
use App\Application\User\CreateUserUseCase;
use App\Infrastructure\Form\UserForm;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Response as OpenApiResponse;
use OpenApi\Attributes\RequestBody;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserEndpoint extends AbstractController
{
    #[Post(tags: ["User"])]
    #[Route(path: "/user", methods: Request::METHOD_POST)]
    public function create(Request $request, CreateUserUseCase $useCase): JsonResponse
    {
        $input = CreateUserInputData::makeEmpty();
        $form = $this->createForm(UserForm::class, $input);
        $form->submit($request->request->all());
        $useCase->create($input);
        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    #[Post(security: [], tags: ["Login"])]
    #[RequestBody(x: [new JsonContent(ref: "#/components/schemas/LoginInputData")])]
    #[OpenApiResponse(
        response: Response::HTTP_OK,
        description: "It route return the bearer token to you use in all another requests.",
        x: [new JsonContent(ref: "#/components/schemas/LoginOutputData")]
    )]
    #[Route(path: "/login_check", methods: Request::METHOD_POST)]
    public function login()
    {}
}
