<?php

namespace App\Domain\Common;

use App\Domain\Exception\EmptyValueException;

class StringValue implements  \Stringable
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $this->setValue($value);
    }

    private function setValue(string $value): string
    {
        return match (empty($value)) {
            true => throw new EmptyValueException(),
            default => $value,
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
