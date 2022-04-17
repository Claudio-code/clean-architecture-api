<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidPriceException extends DomainException
{
    protected const MESSAGE = 'The price cannot be less than or equal to zero.';
    protected const CODE = Response::HTTP_BAD_REQUEST;
}
