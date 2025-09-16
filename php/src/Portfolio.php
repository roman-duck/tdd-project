<?php

namespace App;

class Portfolio
{
    const EUR_TO_USD = 1.2;

    private array $moneys = [];

    private function convert(Money $money, string $currency): Money
    {
        if ($money->getCurrency() === $currency) {
            return $money;
        }
        return new Money($money->getAmount() * self::EUR_TO_USD, $currency);
    }

    public function add(Money ...$moneys): void
    {
        $this->moneys = array_merge($this->moneys, $moneys);
    }

    public function evaluate(string $currency): Money
    {
        $total = array_reduce($this->moneys, function ($sum, Money $money) use ($currency) {
            return $sum + $this->convert($money, $currency)->getAmount();
        }, 0);
        return new Money($total, $currency);
    }
}
