<?php

namespace App\Tests\src\Feature\Application\Client\FindAll;

use App\Application\Common\FindAllPageableInputData;
use PHPUnit\Framework\TestCase;

class FindAllClientInputDataTest extends TestCase
{
    /** @test */
    public function shouldReplaceValuesIfItIsZero(): void
    {
        $input = new FindAllPageableInputData(0, 0);
        self::assertNotEquals(0, $input->getPage());
        self::assertNotEquals(0, $input->getSize());
    }

    /** @test */
    public function shouldNotReplaceValuesIfItNotIsZero(): void
    {
        $input = new FindAllPageableInputData(2, 21);
        self::assertEquals(2, $input->getPage());
        self::assertEquals(21, $input->getSize());
    }
}
