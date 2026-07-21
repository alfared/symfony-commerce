<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

final readonly class UpdateAttributeCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
        public bool $required,
        public bool $filterable,
        public bool $searchable,
        public bool $variantAxis,
        public bool $enabled,
    ) {
    }
}