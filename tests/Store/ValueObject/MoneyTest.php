<?php

namespace App\Tests\Store\ValueObject;

use App\Store\Domain\ValueObject\Currency;
use App\Store\Domain\ValueObject\Money;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MoneyTest extends KernelTestCase
{
    public function testCopiedMoneyShouldRepresentSameValue(): void
    {
        $money = new Money(100, new Currency('USD'));
        $copiedMoney = Money::fromMoney($money);

        $this->assertTrue($money->equals($copiedMoney));
    }

    public function testOriginalMoneyShouldNotBeModifiedOnAddition(): void
    {
        $money = new Money(100, new Currency('USD'));
        $money->add(new Money(50, new Currency('USD')));

        $this->assertEquals(100, $money->getAmount());
    }

    public function testMoniesShouldBeAdded(): void
    {
        $money = new Money(100, new Currency('USD'));
        $added = $money->add(new Money(50, new Currency('USD')));

        $this->assertEquals(150, $added->getAmount());
    }
}
