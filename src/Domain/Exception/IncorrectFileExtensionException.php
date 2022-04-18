<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class IncorrectFileExtensionException extends DomainException
{
    protected const MESSAGE = "This file is not part of the files with allowed extensions.";
    protected const CODE = Response::HTTP_NOT_ACCEPTABLE;
}
