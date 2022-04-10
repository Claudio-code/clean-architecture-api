<?php

namespace App\Infrastructure\Persistence\Exception;

use Symfony\Component\HttpFoundation\Response;

class PersistenceException extends \Exception
{
    protected const MESSAGE = "There was an error in the persistence rule layer.";
    protected const CODE = Response::HTTP_CONFLICT;

    public function __construct()
    {
        parent::__construct($this::MESSAGE, $this::CODE);
    }
}
