<?php

namespace App\Agent\Shared\Dto;

use App\Catalog\Product\Domain\Model\Product;

final readonly class ProductDto
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
        public string $slug,
        public ?string $description,
        public bool $active,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}