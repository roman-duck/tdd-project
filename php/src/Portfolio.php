<?php

namespace App;

class Portfolio
{
    const EUR_TO_USD = 1.2;

    const EXCHANGE_RATES = [
        'EUR->USD' => 1.2, 
        'USD->KRW' => 1100
    ];

    private array $moneys = [];

    private function convert(Money $money, string $currency): int
    {
        if ($money->getCurrency() === $currency) {
            return $money->getAmount();
        }
        $key = $money->getCurrency() . '->' . $currency;
        return $money->getAmount() * self::EXCHANGE_RATES[$key];
    }

    public function add(Money ...$moneys): void
    {
        $this->moneys = array_merge($this->moneys, $moneys);
    }

    public function evaluate(string $currency): Money
    {
        $total = array_reduce($this->moneys, function ($sum, Money $money) use ($currency) {
            return $sum + $this->convert($money, $currency);
        }, 0);
        return new Money($total, $currency);
    }
}
