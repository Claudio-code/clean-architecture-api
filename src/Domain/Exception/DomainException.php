<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class DomainException extends \Exception
{
    protected const MESSAGE = "There was an error in the business rule.";
    protected const CODE = Response::HTTP_BAD_REQUEST;

    public function __construct()
    {
        parent::__construct($this::MESSAGE, $this::CODE);
    }
}
