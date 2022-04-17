<?php

namespace App\Domain\Common;

use App\Domain\Exception\InvalidPriceException;

class Price
{
    private int|float $value;

    public function __construct(int|float $value)
    {
        $this->value = $this->setValue($value);
    }

    public function setValue(float|int $value): float|int
    {
        return match ($value <= 0) {
            true => throw new InvalidPriceException(),
            default => $value,
        };
    }

    public function getValue(): float|int
    {
        return $this->value;
    }
}
