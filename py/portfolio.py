import functools
import operator
from money import Money

class Portfolio:
    def __init__(self):
        self.moneys = []
        self._exchangeRates = {'EUR->USD': 1.2, 'USD->KRW': 1100}

    def __convert(self, aMoney, aCurrency):
        if aMoney.currency == aCurrency:
            return aMoney.amount
        else:
            key = aMoney.currency + '->' + aCurrency
            return aMoney.amount * self._exchangeRates[key]   

    def add(self, *moneys):
        self.moneys.extend(moneys)

    def evaluate(self, currency):
        total = functools.reduce(
            operator.add, map(lambda m: self.__convert(m, currency), self.moneys), 0
        )
        return Money(total, currency)
