<?php

namespace App\Catalog\Manufacturer\Domain\Repository;

use App\Catalog\Manufacturer\Domain\Model\Manufacturer;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerCode;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerId;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerSlug;

interface ManufacturerRepositoryInterface
{
    public function save(Manufacturer $manufacturer): void;

    public function remove(Manufacturer $manufacturer): void;

    public function findById(ManufacturerId $id): ?Manufacturer;

    public function findByCode(ManufacturerCode $code): ?Manufacturer;

    public function findBySlug(ManufacturerSlug $slug): ?Manufacturer;

    public function existsByCode(ManufacturerCode $code): bool;

    public function existsBySlug(ManufacturerSlug $slug): bool;

    /**
     * @return list<Manufacturer>
     */
    public function findAll(): array;
}