package stocks

import "errors"

type Portfolio []Money

func (p Portfolio) Add(money Money) Portfolio {
    p = append(p, money)
    return p
}

func (p Portfolio) Evaluate(bank Bank, currency string) (*Money, error) {
    total := 0.0
    failedConversions := make([]string, 0)
    for _, m := range p {
        if convertedAmount, ok := convert(m, currency); ok {
            total = total + convertedAmount
        } else {
            failedConversions = append(failedConversions, m.currency+"->"+currency)
        }
    }
    if len(failedConversions) == 0 {
        totalMoney := NewMoney(total, currency)
        return &totalMoney, nil
    }
    failures := "["
    for _, f := range failedConversions {
        failures = failures + f + ","
    }
    failures = failures + "]"
    return nil, errors.New("Missing exchange rate(s):" + failures)
}

func convert(money Money, currency string) (float64, bool) {
    if money.currency == currency {
        return money.amount, true
    }
    exchangeRates := map[string]float64{
        "EUR->USD": 1.2,
        "USD->KRW": 1100,
    }
    key := money.currency + "->" + currency
    rate, ok := exchangeRates[key]
    return money.amount * rate, ok
}
