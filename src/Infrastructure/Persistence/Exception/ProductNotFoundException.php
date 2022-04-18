<?php

namespace App\Infrastructure\Persistence\Exception;

use Symfony\Component\HttpFoundation\Response;

class ProductNotFoundException extends PersistenceException
{
    protected const MESSAGE = "There was an error because product not found.";
    protected const CODE = Response::HTTP_NOT_FOUND;
}
