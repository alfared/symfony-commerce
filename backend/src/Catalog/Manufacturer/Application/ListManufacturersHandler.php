<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Application\Query;

use App\Catalog\Manufacturer\Domain\Model\Manufacturer;
use App\Catalog\Manufacturer\Domain\Repository\ManufacturerRepositoryInterface;

final readonly class ListManufacturersHandler
{
    public function __construct(
        private ManufacturerRepositoryInterface $manufacturers,
    ) {
    }

    /**
     * @return list<ManufacturerView>
     */
    public function __invoke(): array
    {
        return array_map(
            static fn (Manufacturer $manufacturer): ManufacturerView =>
                ManufacturerView::fromAggregate($manufacturer),
            $this->manufacturers->findAll(),
        );
    }
}