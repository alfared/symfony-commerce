<?php

namespace App\Agent\ProductVariant\Tools;

use App\Agent\Shared\Base\AbstractTool;
use App\Agent\Shared\Contract\ToolInterface;
use App\Agent\Shared\Tool\ToolResponse;
use App\Agent\Shared\Mapper\ProductVariantMapper;
use App\Catalog\ProductVariant\Application\CreateProductVariantCommand;
use App\Catalog\ProductVariant\Application\CreateProductVariantHandler;
use App\Catalog\ProductVariant\Domain\Model\ProductVariant;
use App\Catalog\ProductVariant\Domain\Repository\ProductVariantRepositoryInterface;
use Mcp\Capability\Attribute\McpTool;

final readonly class ProductVariantTools extends AbstractTool implements ToolInterface
{
    public function __construct(
        private CreateProductVariantHandler $createProductVariant,
        private ProductVariantRepositoryInterface $productVariant,
        private ProductVariantMapper $mapper
    ) {
    }

    #[McpTool(name: 'create_product_variant', description: 'Create a product variant')]
    public function createProductVariant(
        int $productId,
        string $code,
        string $sku,
        int $price,
        int $stock = 0,
        bool $enabled = true,
    ): array {
        return $this->execute(function() use (
            $productId,
            $code,
            $sku,
            $price,
            $stock,
            $enabled
        ): array {
                
            $variant = ($this->createProductVariant)(
                new createProductVariantCommand(
                    productId: $productId,
                    code: $code,
                    sku: $sku,
                    price: $price,
                    stock: $stock,
                    enabled: $enabled
                )
            );

            return $this->mapper->toArray($variant);
        });
    }
}