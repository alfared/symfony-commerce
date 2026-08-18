<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Application\Query;

final readonly class GetManufacturerQuery
{
    public function __construct(
        public string $id,
    ) {
    }
}