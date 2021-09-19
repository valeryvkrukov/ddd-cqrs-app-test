<?php

namespace App\Store\Domain\ValueObject;

use Psr\Log\InvalidArgumentException;

class Money
{
    /**
     * @var int
     */
    private int $amount;

    /**
     * @var Currency
     */
    private Currency $currency;

    /**
     * @param int $amount
     * @param Currency $currency
     */
    public function __construct(int $amount, Currency $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param Currency $currency
     */
    private function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Money $money
     * @return static
     */
    public static function fromMoney(Money $money): self
    {
        return new self(
            $money->getAmount(),
            $money->getCurrency()
        );
    }

    /**
     * @param Currency $currency
     * @return static
     */
    public static function ofCurrency(Currency $currency): self
    {
        return new self(0, $currency);
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function increaseAmountBy(int $amount): self
    {
        return new self(
            $this->getAmount() + $amount,
            $this->getCurrency()
        );
    }

    public function add(Money $money): self
    {
        if (!$money->getCurrency()->equals($this->getCurrency())) {
            throw new InvalidArgumentException(sprintf(
                'Incorrect money currency: current %s, tried to add %s',
                $money->getCurrency()->getIsoCode(),
                $this->getCurrency()->getIsoCode()
            ));
        }

        return new self(
            $this->getAmount() + $money->getAmount(),
            $this->getCurrency()
        );
    }

    /**
     * @param Money $money
     * @return bool
     */
    public function equals(Money $money): bool
    {
        return $this->getAmount() === $money->getAmount()
            && $this->getCurrency()->equals($money->getCurrency());
    }
}