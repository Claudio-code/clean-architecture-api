<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class EmptyValueException extends DomainException
{
    protected const MESSAGE = 'It field is empty';
    protected const CODE = Response::HTTP_BAD_REQUEST;
}