<?php

namespace App\Agent\Shared\Dto;

final readonly class ProductVariantDto
{
    public function __construct(
        public int $id,
        public string $code,
        public ?int $productId,
        public ?string $productCode,
        public int|string|null $price = null,
        public ?int $stock = null,
        public bool $enabled = true,
    ){
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}