<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidEmailException extends DomainException
{
    protected const MESSAGE = "It email is invalid.";
    protected const CODE = Response::HTTP_NOT_ACCEPTABLE;
}
