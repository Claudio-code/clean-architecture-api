<?php

namespace App\Api\Client;

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
}
