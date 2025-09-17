<?php

namespace App;

class Portfolio
{
    private array $moneys = [];

    public function add(Money ...$moneys): void
    {
        $this->moneys = array_merge($this->moneys, $moneys);
    }

    public function evaluate(Bank $bank, string $currency): Money
    {
        if (!$bank->hasCurrency($currency)) {
            throw new \Exception(sprintf("Missing exchange rate(s):[%s->%s]", $currency, $currency));
        }

        $total = 0;
        foreach ($this->moneys as $money) {
            if (!$bank->hasCurrency($money->getCurrency())) {
                throw new \Exception(sprintf("Missing exchange rate(s):[%s->%s]", $money->getCurrency(), $currency));
            }
            $total += $bank->convert($money, $currency)->getAmount();
        }

        return new Money($total, $currency);
    }
}
