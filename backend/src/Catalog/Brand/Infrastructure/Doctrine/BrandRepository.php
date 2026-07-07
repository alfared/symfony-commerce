<?php

namespace App\Catalog\Brand\Infrastructure\Doctrine;

use App\Catalog\Brand\Domain\Model\Brand;
use App\Catalog\Brand\Domain\Repository\BrandRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class BrandRepository extends ServiceEntityRepository implements BrandRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function findById(int $id): ?Brand
    {
        return $this->find($id);
    }

    public function findOneByCode(string $code): ?Brand
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function save(Brand $brand): void
    {
        $this->getEntityManager()->persist($brand);
        $this->getEntityManager()->flush();
    }
}