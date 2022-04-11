<?php

namespace App\Infrastructure\Persistence\Exception;

use Symfony\Component\HttpFoundation\Response;

class ClientNotFoundException extends PersistenceException
{
    protected const MESSAGE = "There was an error because client not found.";
    protected const CODE = Response::HTTP_NOT_FOUND;
}
