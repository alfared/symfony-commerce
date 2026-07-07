<?php

namespace App\Catalog\Category\Infrastructure\Doctrine;

use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findAllEnabled(): array 
    {
        return $this->createQueryBuilder('category')
            ->andWhere('category.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('category.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findById(int $id): ?Category
    {
        return $this->find($id);
    }

    public function findOneByCode(string $code): ?Category
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function save(Category $category): void
    {
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }
}