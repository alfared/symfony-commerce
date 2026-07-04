<?php

namespace App\Agent\Shared\Mapper;

use App\Agent\Shared\Dto\ProductVariantDto;
use App\Catalog\ProductVariant\Domain\Model\ProductVariant;

final readonly class ProductVariantMapper
{
    public function toArray(ProductVariant $variant): array
    {
        return new ProductVariantDto(
            id: $variant->getId(),
            code: $variant->getCode(),
            productId: $variant->getProduct()?->getId(),
            productCode: $variant->getProduct()?->getCode(),
            price: method_exists($variant, 'getPrice') ? $variant->getPrice() : null,
            stock: method_exists($variant, 'getStock') ? $variant->getStock() : null,
            enabled: method_exists($variant, 'isEnabled') ? $variant->isEnabled() : true,
        )->toArray();
    }


    /**
     * @param ProductVariant[] $variants
     */
    public function manyToArray(array $variants): array
    {
        return array_map(fn (ProductVariant $variant): array => $this->toArray($variant), $variants);
    }
}