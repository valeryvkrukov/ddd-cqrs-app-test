<?php

namespace App\Store\Domain\ValueObject;

use Money\Currencies\ISOCurrencies;
use Money\Currency as IsoCurrency;
use Psr\Log\InvalidArgumentException;

class Currency
{
    /**
     * @var string
     */
    private string $isoCode;

    /**
     * @param string $isoCode
     */
    public function __construct(string $isoCode)
    {
        $this->setIsoCode($isoCode);
    }

    /**
     * @param string $isoCode
     */
    private function setIsoCode(string $isoCode): void
    {
        if (!(new ISOCurrencies())->contains(new IsoCurrency($isoCode))) {
            throw new InvalidArgumentException(sprintf('ISO code %s is not exists.', $isoCode));
        }
        $this->isoCode = $isoCode;
    }

    /**
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * @param Currency $currency
     * @return bool
     */
    public function equals(Currency $currency): bool
    {
        return $this->getIsoCode() === $currency->getIsoCode();
    }
}