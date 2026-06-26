<?php

namespace App\Catalog\Product\Infrastructure\Doctrine;

use App\Catalog\Product\Domain\Model\Product;
use App\Catalog\Product\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


final class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findOneByCode(string $code): ?Product
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }
}
