<?php

namespace App\Infrastructure\Persistence\Exception;

use Symfony\Component\HttpFoundation\Response;

class ProductAlreadyExistsInTheDatabaseException extends PersistenceException
{
    protected const MESSAGE = "This product already exists in the database exception.";
    protected const CODE = Response::HTTP_CONFLICT;
}
