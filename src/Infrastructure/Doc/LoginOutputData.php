<?php

namespace App\Infrastructure\Doc;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
class LoginOutputData
{
    #[Property(default: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9")]
    public string $token;
}