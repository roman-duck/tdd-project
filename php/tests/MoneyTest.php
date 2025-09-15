<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Dollar;

class MoneyTest extends TestCase
{
    public function testMultiplication(): void
    {
        $fiver = new Dollar(5);
        $tenner = $fiver->times(2);
        $this->assertEquals(10, $tenner->getAmount());
    }
}
