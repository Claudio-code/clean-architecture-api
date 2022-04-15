<?php

namespace App\Infrastructure\Doc;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody(required: true)]
class LoginInputData
{
    #[Property(default: "claudio@gmail.com")]
    public string $username;

    #[Property(default: "123")]
    public string $password;
}
