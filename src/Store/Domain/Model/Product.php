<?php

namespace App\Store\Domain\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private int $productId;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(type="money")
     *
     * @var Money
     */
    private Money $price;

    /**
     * @param string $name
     * @param Money $price
     */
    public function __construct(
        string $name,
        Money $price
    ) {
        $this->setName($name);
        $this->setPrice($price);
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param Money $price
     */
    private function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }
}