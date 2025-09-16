<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Money;

class MoneyTest extends TestCase
{
    public function testMultiplicationInDollars(): void
    {
        $fiver = new Money(5, "USD");
        $tenner = $fiver->times(2);
        $this->assertEquals('USD', $tenner->getCurrency());
        $this->assertEquals(10, $tenner->getAmount());
    }

    public function testMultiplicationInEuros(): void
    {
        $tenEuros = new Money(10, "EUR");
        $twentyEuros = $tenEuros->times(2);
        $this->assertEquals('EUR', $twentyEuros->getCurrency());
        $this->assertEquals(20, $twentyEuros->getAmount());
    }

    public function testDivision(): void
    {
        $originalMoney = new Money(4002, "KRW");
        $actualMoneyAfterDivision  = $originalMoney->divide(4);
        $expectedMoneyAfterDivision = new Money(1000.5, "KRW");
        $this->assertEquals($expectedMoneyAfterDivision->getAmount(), $actualMoneyAfterDivision->getAmount());
        $this->assertEquals($expectedMoneyAfterDivision->getCurrency(), $actualMoneyAfterDivision->getCurrency());
    }
}
