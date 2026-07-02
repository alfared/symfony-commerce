<?php

namespace App\Agent\Product\Resources;

use App\Agent\Shared\Base\AbstractResource;
use App\Agent\Shared\Contract\ResourceInterface;
use App\Agent\Shared\Mapper\ProductMapper;
use App\Catalog\Product\Domain\Repository\ProductRepositoryInterface;
use Mcp\Capability\Attribute\McpResource;

final readonly class ProductResources extends AbstractResource implements ResourceInterface
{
    public function __construct(
        private ProductRepositoryInterface $products,
        private ProductMapper $mapper,
    ) {
    }

    #[McpResource(
        uri: 'product://list',
        name: 'product_list',
        description: 'List catalog products'
    )]
    public function listProducts(): array
    {
        return $this->collection(
            $this->mapper->manyToArray($this->products->findAll())
        );
    }
}