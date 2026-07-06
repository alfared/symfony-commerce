<?php

namespace App\Agent\ProductVariant\Resources;

use App\Agent\Shared\Base\AbstractResource;
use App\Agent\Shared\Contract\ResourceInterface;
use App\Agent\Shared\Mapper\ProductVariantMapper;
use App\Catalog\ProductVariant\Domain\Repository\ProductVariantRepositoryInterface;
use Mcp\Capability\Attribute\McpResource;

final readonly class ProductVariantResources extends AbstractResource implements ResourceInterface
{
    public function __construct(
        private ProductVariantRepositoryInterface $products,
        private ProductVariantMapper $mapper,
    ) {
    }

    #[McpResource(
        uri: 'product_variant://list',
        name: 'product_variant_list',
        description: 'List product variants'
    )]
    public function listProductVariants(): array 
    {
        return $this->collection(
            $this->mapper->manyToArray($this->variants->findAll())
        );
    }
}