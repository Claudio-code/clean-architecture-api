<?php

namespace App\Api\FavoriteProductsListOfClient;

use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteProductsListOfClientEndPoint extends AbstractController
{
    private const ROUTE_PATH = '/product/favorite';

    #[Post(tags: ["FavoriteProductsListOfClient"])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_POST)]
    public function addProductInList()
    {

    }

    #[Delete(tags: ["FavoriteProductsListOfClient"])]
    #[Route(path: self::ROUTE_PATH, methods: Request::METHOD_DELETE)]
    public function removeProductInList()
    {

    }
}