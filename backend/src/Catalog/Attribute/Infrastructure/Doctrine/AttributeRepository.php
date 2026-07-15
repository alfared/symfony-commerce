<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Doctrine;

use App\Catalog\Attribute\Domain\Model\Attribute;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class AttributeRepository extends ServiceEntityRepository implements AttributeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attribute::class);
    }

    public function save(Attribute $attribute): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($attribute);
        $entityManager->flush();
    }

    public function remove(Attribute $attribute): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($attribute);
        $entityManager->flush();
    }

    public function findById(AttributeId $id): ?Attribute
    {
        /** @var Attribute|null $attribute */
        $attribute = $this->findOneBy([
            'id' => $id,
        ]);

        return $attribute;
    }

    public function findByCode(AttributeCode $code): ?Attribute
    {
        /** @var Attribute|null $attribute */
        $attribute = $this->findOneBy([
            'code' => $code,
        ]);

        return $attribute;
    }

    public function exists(AttributeCode $code): bool
    {
        $result = $this->createQueryBuilder('attribute')
            ->select('1')
            ->where('attribute.code = :code')
            ->setParameter('code', $code, 'attribute_code')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result !== null;
    }
}