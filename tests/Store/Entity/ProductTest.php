<?php

namespace App\Tests\Store\Entity;


use App\Store\Domain\Model\Currency;
use App\Store\Domain\Model\Money;
use App\Store\Domain\Model\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    const TEST_NAME = 'Test product #1';

    /**
     * @var EntityManager|null
     */
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @throws ORMException
     */
    public function testCreateProduct(): void
    {
        $product = new Product(
            self::TEST_NAME,
            new Money(120, new Currency('USD'))
        );
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $created = $this->entityManager->getRepository(Product::class)->findOneBy([
            'name' => self::TEST_NAME,
        ]);

        $this->assertNotNull($created);
        $this->assertNotEmpty($created);
        $this->assertEquals($product->getName(), $created->getName());
        $this->assertEquals($product->getPrice(), $created->getPrice());
    }

    /**
     * @throws ORMException
     */
    public function testDeleteProduct(): void
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy([
            'name' => self::TEST_NAME,
        ]);
        $this->assertNotNull($product);
        $this->assertNotEmpty($product);

        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
