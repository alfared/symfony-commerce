<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

final readonly class AddAttributeOptionCommand
{
     public function __construct(
        public string $attributeId,
        public string $code,
        public string $name,
        public int $sortOrder = 0,
    ) {
    }
}