<?php

namespace App\Agent\Shared\Mapper;

use App\Agent\Shared\Dto\ProductDto;
use App\Catalog\Product\Domain\Model\Product;

final readonly class ProductMapper
{
    public function toDto(Product $product): ProductDto
    {
        return new ProductDto(
            id: $product->getId(),
            code: $product->getCode(),
            name: $product->getName(),
            slug: $product->getSlug(),
            description: $product->getDescription(),
            active: $product->isActive(),
        );
    }

    public function toArray(Product $product): array
    {
        return $this->toDto($product)->toArray();
    }

    /**
     * @param Product[] $products
     */
    public function manyToArray(array $products): array
    {
        return array_map(
            fn (Product $product): array => $this->toArray($product),
            $products
        );
    }
}