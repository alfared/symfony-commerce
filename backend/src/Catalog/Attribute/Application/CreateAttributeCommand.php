<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

final readonly class CreateAttributeCommand
{
    public function __construct(
        public string $code,
        public string $name,
        public string $type,
        public bool $required = false,
        public bool $filterable = false,
        public bool $searchable = false,
        public bool $variantAxis = false,
    ) {
    }
}