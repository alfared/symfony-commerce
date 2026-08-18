<?php

namespace App\Catalog\Manufacturer\Infrastructure\Doctrine;

use App\Catalog\Manufacturer\Domain\Model\Manufacturer;
use App\Catalog\Manufacturer\Domain\Repository\ManufacturerRepositoryInterface;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerCode;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerId;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerSlug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Override;

final class ManufacturerRepository extends ServiceEntityRepository implements ManufacturerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manufacturer::class);
    }

    public function save(Manufacturer $manufacturer): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($manufacturer);
        $entityManager->flush();
    }

    public function remove(Manufacturer $manufacturer): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($manufacturer);
        $entityManager->flush();
    }

    public function findById(ManufacturerId $id): ?Manufacturer
    {
        /** @var Manufacturer|null $manufacturer */
        $manufacturer = $this->findOneBy([
            'id' => $id,
        ]);

        return $manufacturer;
    }

    public function findByCode(ManufacturerCode $code): ?Manufacturer
    {
        /** @var Manufacturer|null $manufacturer */
        $manufacturer = $this->findOneBy([
            'code' => $code,
        ]);

        return $manufacturer;
    }

    public function findBySlug(ManufacturerSlug $slug): ?Manufacturer
    {
        /** @var Manufacturer|null $manufacturer */
        $manufacturer = $this->findOneBy([
            'slug' => $slug,
        ]);

        return $manufacturer;
    }

    /**
     * @return list<Manufacturer>
     */
    #[Override]
    public function findAll(): array
    {
        /** @var list<Manufacturer> $manufacturers */
        $manufacturers = $this->createQueryBuilder('manufacturer')
            ->orderBy('manufacturer.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $manufacturers;
        
    }


    public function existsByCode(ManufacturerCode $code): bool
    {
        return $this->findByCode($code) !== null;
    }

    public function existsBySlug(ManufacturerSlug $slug): bool
    {
        return $this->findBySlug($slug) !== null;
    }
}