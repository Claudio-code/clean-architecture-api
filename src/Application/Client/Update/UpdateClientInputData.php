<?php

namespace App\Application\Client\Update;

use App\Application\Client\Create\CreateClientInputData;

class UpdateClientInputData extends CreateClientInputData
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public static function makeEmpty(): self
    {
        return new self();
    }
}
