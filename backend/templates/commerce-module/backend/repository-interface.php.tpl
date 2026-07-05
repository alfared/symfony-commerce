<?php

namespace App\{{ Context }}\{{ Entity }}\Domain\Repository;

use App\{{ Context }}\ {{ Entity }}\Domain\Model\{{ Entity }};

interface {{ Entity }}RepositoryInterface
{
    /**
     * @return {{ Entity }}[]
     */
    public function findAll(): array;

    public function findById(int $id): ?{{ Entity }}

    public function findOneByCode(string $code): ?{{ Entity }};

    public function save({{ Entity }}) ${{ entity }}: void;
}