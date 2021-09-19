<?php

namespace App\Store\Infrastructure\Persistence\Doctrine\Type;

use App\Store\Domain\Model\Currency;
use App\Store\Domain\Model\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

class MoneyType extends TextType
{
    const MONEY = 'money';

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Money
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Money
    {
        $value = parent::convertToPHPValue($value, $platform);
        $value = explode('|', $value);

        return new Money(
            $value[0],
            new Currency($value[1])
        );
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof Money) {
            return implode('|', [
                $value->getAmount(),
                $value->getCurrency()->getIsoCode()
            ]);
        } else {
            return parent::convertToDatabaseValue($value, $platform);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::MONEY;
    }
}