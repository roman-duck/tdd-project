<?php

namespace App;

class Portfolio
{
    const EUR_TO_USD = 1.2;

    const CURRENCIES = ['USD', 'EUR', 'KRW'];

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
        if (!in_array($currency, self::CURRENCIES)) {
            throw new \Exception(sprintf("Missing exchange rate(s):[%s->%s]", $currency, $currency));
        }

        $total = 0;
        foreach ($this->moneys as $money) {
            if (!in_array($money->getCurrency(), self::CURRENCIES)) {
                throw new \Exception(sprintf("Missing exchange rate(s):[%s->%s]", $money->getCurrency(), $currency));
            }
            $total += $this->convert($money, $currency);
        }

        return new Money($total, $currency);
    }
}
