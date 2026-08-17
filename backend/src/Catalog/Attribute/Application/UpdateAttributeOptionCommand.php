<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

final readonly class UpdateAttributeOptionCommand
{
    public function __construct(
        public string $attributeId,
        public string $optionId,
        public string $name,
        public int $sortOrder,
        public bool $enabled,
    ) {
    }
}