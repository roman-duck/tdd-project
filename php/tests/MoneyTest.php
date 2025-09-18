<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Money;
use App\Portfolio;
use App\Bank;

class MoneyTest extends TestCase
{
    private Bank $bank;
     
    public function setUp(): void 
    {
        parent::setUp();
        $this->bank = new Bank();
        $this->bank->addExchangeRate("EUR", "USD", 1.2);
        $this->bank->addExchangeRate("USD", "KRW", 1100);
    }

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
        $this->assertTrue($fifteenDollars->isEqual($portfolio->evaluate($this->bank, "USD")));
    }

    public function testConversion(): void
    {
        $bank = new Bank();
        $bank->addExchangeRate("EUR", "USD", 1.2);
        $tenEuros = new Money(10, "EUR");
        $this->assertEquals($bank->convert($tenEuros, "USD"), new Money(12, "USD"));
        $this->assertEquals($this->bank->convert($tenEuros, "USD"), new Money(12, "USD"));
        $this->bank->addExchangeRate("EUR", "USD", 1.3);
        $this->assertEquals($this->bank->convert($tenEuros, "USD"), new Money(13, "USD"));
    }   

    public function testAdditionOfDollarsAndEuros(): void
    {
        $fiveDollars = new Money(5, "USD");
        $tenEuros = new Money(10, "EUR");
        $portfolio = new Portfolio();
        $portfolio->add($fiveDollars, $tenEuros);
        $expectedValue = new Money(17, "USD");
        $actualValue = $portfolio->evaluate($this->bank, "USD");
        $this->assertTrue($expectedValue->isEqual($actualValue));
    }

    public function testAdditionOfDollarsAndWons(): void
    {
        $oneDollar = new Money(1, "USD");
        $elevenHundredWons = new Money(1100, "KRW");
        $portfolio = new Portfolio();
        $portfolio->add($oneDollar, $elevenHundredWons);
        $expectedValue = new Money(2200, "KRW");
        $actualValue = $portfolio->evaluate($this->bank, "KRW");
        $this->assertTrue($expectedValue->isEqual($actualValue));
    }

    public function testAdditionWithMultipleMissingExchangeRates(): void
    {
        $oneDollar = new Money(1, "USD");
        $oneEuro = new Money(1, "EUR");
        $oneWon = new Money(1, "KRW");
        $portfolio = new Portfolio();
        $portfolio->add($oneDollar, $oneEuro, $oneWon);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Missing exchange rate(s):[Kalganid->Kalganid]");
        $portfolio->evaluate($this->bank, "Kalganid");
    }

    public function testWhatIsTheConversionRateFromEURToUSD(): void
    {
        $tenEuros = new Money(10, "EUR");
        $this->assertEquals($this->bank->convert($tenEuros, "USD"), new Money(12, "USD"));
    }
}
