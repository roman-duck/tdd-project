<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Money;

class MoneyTest extends TestCase
{
    public function testMultiplicationInDollars(): void
    {
        $fiveDollars = new Money(5, "USD");
        $tenDollars = $fiveDollars->times(2);
        $this->assertEquals($tenDollars, $fiveDollars->times(2));
    }

    public function testMultiplicationInEuros(): void
    {
        $tenEuros = new Money(10, "EUR");
        $twentyEuros = $tenEuros->times(2);
        $this->assertEquals($twentyEuros, $tenEuros->times(2));
    }

    public function testDivision(): void
    {
        $originalMoney = new Money(4002, "KRW");
        $actualMoneyAfterDivision = $originalMoney->divide(4);
        $expectedMoneyAfterDivision = new Money(1000.5, "KRW");
        $this->assertEquals($expectedMoneyAfterDivision->getAmount(), $actualMoneyAfterDivision->getAmount());
        $this->assertEquals($expectedMoneyAfterDivision->getCurrency(), $actualMoneyAfterDivision->getCurrency());
    }
}
