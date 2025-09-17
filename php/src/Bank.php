<?php

namespace App;

class Bank 
{
    private array $currencies = [];

    private array $exchangeRates = [];

    public function addExchangeRate(string $fromCurrency, string $toCurrency, float $rate): void
    {
        $key = $fromCurrency . '->' . $toCurrency;
        $this->exchangeRates[$key] = $rate;
        $this->currencies[] = $fromCurrency;
        $this->currencies[] = $toCurrency;
    }

    public function convert(Money $money, string $currency): Money
    {
        if ($money->getCurrency() === $currency) {
            return new Money($money->getAmount(), $currency);
        }

        $key = $money->getCurrency() . '->' . $currency;
        if (!isset($this->exchangeRates[$key])) {
            throw new \Exception(sprintf("Missing exchange rate(s):[%s->%s]", $money->getCurrency(), $currency));
        }

        $convertedAmount = $money->getAmount() * $this->exchangeRates[$key];

        return new Money($convertedAmount, $currency);
    }

    public function hasCurrency(string $currency): bool
    {
        return in_array($currency, $this->currencies);
    }
}