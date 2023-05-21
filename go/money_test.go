package main

import (
    "testing"
)

func TestMultiplicationInDollars(t *testing.T) {
    fiver := Money{amount: 5, currency: "USD"}
    actualResult := fiver.Times(2)
    expectedResult := Money{amount: 10, currency: "USD"}
    assertEqual(t, expectedResult, actualResult)
}

func TestMultiplicationInEuros(t *testing.T) {
    tenEuros := Money{amount: 10, currency: "EUR"}
    actualResult := tenEuros.Times(2)
    expectedResult := Money{amount: 20, currency: "EUR"}
    assertEqual(t, expectedResult, actualResult)
}

func TestDivision(t *testing.T) {
    originalMoney := Money{amount: 4002, currency: "KRW"}
    actualResult := originalMoney.Divide(4)
    expectedResult := Money{amount: 1000.5, currency: "KRW"}
    assertEqual(t, expectedResult, actualResult)
}

func TestAddition(t *testing.T) {
    var portfolio Portfolio
    var portfolioInDollars Money

    fiveDollars := Money{amount: 5, currency: "USD"}
    tenDollars := Money{amount: 10, currency: "USD"}
    fifteenDollars := Money{amount: 15, currency: "USD"}

    portfolio = portfolio.Add(fiveDollars)
    portfolio = portfolio.Add(tenDollars)
    portfolioInDollars = portfolio.Evaluate("USD")

    assertEqual(t, fifteenDollars, portfolioInDollars)
}

func assertEqual(t *testing.T, expected Money, actual Money) {
    if expected != actual {
        t.Errorf("Expected %+v, got %+v", expected, actual)
    }
}

type Money struct {
    amount float64
    currency string
}

func (m Money) Times(multiplier int) Money {
    return Money{amount: m.amount * float64(multiplier), currency: m.currency}
}

func (m Money) Divide(divisor int) Money {
    return Money{amount: m.amount / float64(divisor), currency: m.currency}
}

type Portfolio []Money

func (p Portfolio) Add(money Money) Portfolio {
    p = append(p, money)
    return p
}

func (p Portfolio) Evaluate(currency string) Money {
    total := 0.0
    for _, m := range p {
        total = total + m.amount
    }
    return Money{amount: total, currency: "USD"}
}
