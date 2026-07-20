<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Domain\Repository;

use App\Catalog\Attribute\Domain\Model\Attribute;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;

interface AttributeRepositoryInterface
{
    public function save(Attribute $attribute): void;

    public function remove(Attribute $attribute): void;

    public function findById(AttributeId $id): ?Attribute;

    public function findByCode(AttributeCode $code): ?Attribute;

    public function exists(AttributeCode $code): bool;

    /**
     * @return list<Attribute>
     */
    public function findAll(): array;
}