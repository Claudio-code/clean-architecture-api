<?php

namespace App\Api\Form\Exception;

use Exception;

class FormException extends Exception
{
    public static function jsonRequestContentError(string $message): self
    {
        return new self($message, 404);
    }
}
