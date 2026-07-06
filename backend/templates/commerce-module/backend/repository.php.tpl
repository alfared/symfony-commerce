<?php

namespace App\{{ Context }}\{{ Entity }}\Infrastructure\Doctrine;

use App\{{ Context }}\{{ Entity }}\Domain\Model\{{ Entity }};
use App\{{ Context }}\{{ Entity }}\Domain\Repository\{{ Entity }}RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class {{ Entity }}Repository extends ServiceEntityRepository implements {{ Entity }}RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, {{ Entity }}::class);
    }

    public function findById(int $id): ?{{ Entity }}
    {
        return $this->find($id);
    }

    public function findOneByCode(string $code): ?{{ Entity }}
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function save({{ Entity }} ${{ entity }}): void
    {
        $this->getEntityManager()->persist(${{ entity }});
        $this->getEntityManager()->flush();
    }
}