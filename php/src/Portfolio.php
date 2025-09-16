<?php

namespace App;

class Portfolio
{
    private array $moneys = [];

    public function add(Money ...$moneys): void
    {
        $this->moneys = array_merge($this->moneys, $moneys);
    }

    public function evaluate(string $currency): Money
    {
        $total = array_reduce($this->moneys, function ($sum, Money $money) use ($currency) {
            return $sum + $money->getAmount();
        }, 0);
        return new Money($total, $currency);
    }
}
