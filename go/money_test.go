package main

import (
    "testing"
    s "tdd/stocks"
)

func TestMultiplicationInDollars(t *testing.T) {
    fiveDollars := s.NewMoney(5, "USD")
    actualResult := fiveDollars.Times(2)
    expectedResult := s.NewMoney(10, "USD")
    assertEqual(t, expectedResult, actualResult)
}

func TestMultiplicationInEuros(t *testing.T) {
    tenEuros := s.NewMoney(10, "EUR")
    actualResult := tenEuros.Times(2)
    expectedResult := s.NewMoney(20, "EUR")
    assertEqual(t, expectedResult, actualResult)
}

func TestDivision(t *testing.T) {
    originalMoney := s.NewMoney(4002, "KRW")
    actualResult := originalMoney.Divide(4)
    expectedResult := s.NewMoney(1000.5, "KRW")
    assertEqual(t, expectedResult, actualResult)
}

func TestAddition(t *testing.T) {
    var portfolio s.Portfolio
    var portfolioInDollars s.Money

    fiveDollars := s.NewMoney(5, "USD")
    tenDollars := s.NewMoney(10, "USD")
    fifteenDollars := s.NewMoney(15, "USD")

    portfolio = portfolio.Add(fiveDollars)
    portfolio = portfolio.Add(tenDollars)
    portfolioInDollars = portfolio.Evaluate("USD")

    assertEqual(t, fifteenDollars, portfolioInDollars)
}

func TestAdditionOfDollarsAndEuros(t *testing.T) {
    var portfolio s.Portfolio

    fiveDollars := s.NewMoney(5, "USD")
    tenEuros := s.NewMoney(10, "EUR")

    portfolio = portfolio.Add(fiveDollars)
    portfolio = portfolio.Add(tenEuros)

    expectedValue := s.NewMoney(17, "USD")
    actualValue := portfolio.Evaluate("USD")

    assertEqual(t, expectedValue, actualValue)
}

func assertEqual(t *testing.T, expected s.Money, actual s.Money) {
    if expected != actual {
        t.Errorf("Expected %+v, got %+v", expected, actual)
    }
}
