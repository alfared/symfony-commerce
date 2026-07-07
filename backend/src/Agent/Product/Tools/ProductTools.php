<?php

namespace App\Agent\Product\Tools;

use App\Agent\Shared\Base\AbstractTool;
use App\Agent\Shared\Contract\ToolInterface;
use App\Agent\Shared\Tool\ToolResponse;
use App\Agent\Shared\Mapper\ProductMapper;
use App\Catalog\Product\Application\CreateProductCommand;
use App\Catalog\Product\Application\CreateProductHandler;
use App\Catalog\Product\Application\UpdateProductCommand;
use App\Catalog\Product\Application\UpdateProductHandler;
use App\Catalog\Product\Domain\Model\Product;
use App\Catalog\Product\Domain\Repository\ProductRepositoryInterface;
use Mcp\Capability\Attribute\McpTool;

final readonly class ProductTools extends AbstractTool implements ToolInterface
{
    public function __construct(
        private CreateProductHandler $createProduct,
        private UpdateProductHandler $updateProduct,
        private ProductRepositoryInterface $products,
        private ProductMapper $mapper
    ) {
    }

    #[McpTool(name: 'create_product', description: 'Create a product')]
     public function createProduct(
       string $code,
       string $name,
       string $slug,
       ?string $description = null,
       bool $active = true,
    ): array {
       try {
            $product = ($this->createProduct)(new CreateProductCommand(
                code: $code,
                name: $name,
                slug: $slug,
                description: $description,
                active: $active,
            ));

            return ToolResponse::success($this->mapper->toArray($product))->toArray();
       } catch (\Throwable $exception) {
            return ToolResponse::error($exception->getMessage())->toArray();
       }
    }

    #[McpTool(name: 'update_product', description: 'Update a product')]
    public function updateProduct(
        int $id,
        ?string $code = null,
        ?string $name = null,
        ?string $slug = null,
        ?string $description = null,
        ?bool $active = null,
    ): array {
        return $this->execute(function () use ($id, $code, $slug, $description, $active): array {
            $product = ($this->updateProduct)(new UpdateProductCommand(
                id: $id,
                code: $code,
                name: $name,
                slug: $slug,
                description: $description,
                active: $active,
            ));

            return $this->mapper->toArray($product);
        });
    }

    #[McpTool(name: 'list_products', description: 'List enabled products')]
    public function listProducts(): array 
    {
       try {
            return ToolResponse::success(
               $this->mapper->manyToArray($this->products->findAllEnabled())
            )->toArray();
       } catch (\Throwable $exception) {
            return ToolResponse::error($exception->getMessage())->toArray();
       }
    }

    #[McpTool(name: 'get_product_by_code', description: 'Get a product by code')]
    public function getProductByCode(string $code): array
    {
        return $this->execute(function () use ($code): array {
            $product = $this->products->findOneByCode($code);

            if (!$product instanceof Product) {
                throw new \RuntimeException('Product not found');
            }

            return $this->mapper->toArray($product);
        });
    }
}