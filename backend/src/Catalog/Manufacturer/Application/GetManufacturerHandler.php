<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Application\Query;

use App\Catalog\Manufacturer\Domain\Exception\ManufacturerNotFound;
use App\Catalog\Manufacturer\Domain\Repository\ManufacturerRepositoryInterface;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerId;

final readonly class GetManufacturerHandler
{
    public function __construct(
        private ManufacturerRepositoryInterface $manufacturers,
    ) {
    }

    public function __invoke(GetManufacturerQuery $query): ManufacturerView
    {
        $id = new ManufacturerId($query->id);

        $manufacturer = $this->manufacturers->findById($id);

        if ($manufacturer === null) {
            throw ManufacturerNotFound::withId($query->id);
        }

        return ManufacturerView::fromAggregate($manufacturer);
    }
}