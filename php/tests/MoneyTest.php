<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Money;
use App\Portfolio;

class MoneyTest extends TestCase
{
    public function testMultiplicationInDollars(): void
    {
        $fiveDollars = new Money(5, "USD");
        $tenDollars = $fiveDollars->times(2);
        $this->assertTrue($tenDollars->isEqual($fiveDollars->times(2)));
    }

    public function testMultiplicationInEuros(): void
    {
        $tenEuros = new Money(10, "EUR");
        $twentyEuros = $tenEuros->times(2);
        $this->assertTrue($twentyEuros->isEqual($tenEuros->times(2)));
    }

    public function testDivision(): void
    {
        $originalMoney = new Money(4002, "KRW");
        $actualMoneyAfterDivision = $originalMoney->divide(4);
        $expectedMoneyAfterDivision = new Money(1000.5, "KRW");
        $this->assertEquals($expectedMoneyAfterDivision->getAmount(), $actualMoneyAfterDivision->getAmount());
        $this->assertEquals($expectedMoneyAfterDivision->getCurrency(), $actualMoneyAfterDivision->getCurrency());
    }

    public function testAddition(): void
    {
        $fiveDollars = new Money(5, "USD");
        $tenDollars = new Money(10, "USD");
        $fifteenDollars = new Money(15, "USD");
        $portfolio = new Portfolio();
        $portfolio->add($fiveDollars, $tenDollars);
        $this->assertTrue($fifteenDollars->isEqual($portfolio->evaluate("USD")));
    }

    public function testAdditionOfDollarsAndEuros(): void
    {
        $fiveDollars = new Money(5, "USD");
        $tenEuros = new Money(10, "EUR");
        $portfolio = new Portfolio();
        $portfolio->add($fiveDollars, $tenEuros);
        $expectedValue = new Money(17, "USD");
        $actualValue = $portfolio->evaluate("USD");
        $this->assertTrue($expectedValue->isEqual($actualValue));
    }

    public function testAdditionOfDollarsAndWons(): void
    {
        $oneDollar = new Money(1, "USD");
        $elevenHundredWons = new Money(1100, "KRW");
        $portfolio = new Portfolio();
        $portfolio->add($oneDollar, $elevenHundredWons);
        $expectedValue = new Money(2200, "KRW");
        $actualValue = $portfolio->evaluate("KRW");
        $this->assertTrue($expectedValue->isEqual($actualValue));
    }
}
