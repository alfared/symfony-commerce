<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application\Query;

final readonly class GetAttributeQuery
{
    public function __construct(
        public string $id,
    ) {
    }
}