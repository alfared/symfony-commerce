<?php

namespace App\Catalog\ProductVariant\Infrastructure\Doctrine;

use App\Catalog\ProductVariant\Domain\Repository\ProductVariantRepositoryInterface;
use App\Catalog\ProductVariant\Domain\Model\ProductVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductVariant>
 */
class ProductVariantRepository extends ServiceEntityRepository implements ProductVariantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVariant::class);
    }

    public function findById(int $id): ?ProductVariant
    {
        return $this->find($id);
    }

    public function findOneByCode(string $code): ?ProductVariant
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function save(ProductVariant $variant): void
    {
        $this->getEntityManager()->persist($variant);
        $this->getEntityManager()->flush();
    }
}
