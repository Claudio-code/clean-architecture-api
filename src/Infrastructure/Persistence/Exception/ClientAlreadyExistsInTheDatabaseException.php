<?php

namespace App\Infrastructure\Persistence\Exception;

use Symfony\Component\HttpFoundation\Response;

class ClientAlreadyExistsInTheDatabaseException extends PersistenceException
{
    protected const MESSAGE = "This client already exists in the database exception.";
    protected const CODE = Response::HTTP_CONFLICT;
}
