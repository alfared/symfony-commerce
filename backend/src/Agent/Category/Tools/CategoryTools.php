<?php

namespace App\Agent\Category\Tools;

use App\Agent\Shared\Base\AbstractTool;
use App\Agent\Shared\Contract\ToolInterface;
use App\Agent\Shared\Tool\ToolResponse;
use App\Agent\Shared\Mapper\CategoryMapper;
use App\Catalog\Category\Application\CreateCategoryCommand;
use App\Catalog\Category\Application\CreateCategoryHandler;
use App\Catalog\Category\Application\UpdateCategoryCommand;
use App\Catalog\Category\Application\UpdateCategoryHandler;
use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Mcp\Capability\Attribute\McpTool;

final readonly class CategoryTools extends AbstractTool implements ToolInterface
{
    public function __construct(
        private CreateCategoryHandler $createCategory,
        private UpdateCategoryHandler $updateCategory,
        private CategoryRepositoryInterface $categories,
        private CategoryMapper $mapper
    ) {
    }

    #[McpTool(name: 'create_category', description: 'Create a catalog category')]
    public function createCategory(
       string $code,
       string $name,
       string $slug,
       ?string $description = null,
       bool $enabled = true,
    ): array {
       try {
            $category = ($this->createCategory)(new CreateCategoryCommand(
                code: $code,
                name: $name,
                slug: $slug,
                description: $description,
                enabled: $enabled,
            ));

            return ToolResponse::success($this->mapper->toArray($category))->toArray();
       } catch (\Throwable $exception) {
            return ToolResponse::error($exception->getMessage())->toArray();
       }
    }

    #[McpTool(name: 'update_category', description: 'Update a catalog category')]
    public function updateCategory(
        int $id,
        ?string $code = null,
        ?string $name = null,
        ?string $slug = null,
        ?string $description = null,
        ?bool $enabled = null,
    ): array {
        return $this->execute(function () use ($id, $code, $name, $slug, $description, $enabled): array {
            $category = ($this->updateCategory)(new UpdateCategoryCommand(
                id: $id,
                code: $code,
                name: $name,
                slug: $slug,
                description: $description,
                enabled: $enabled,
            ));

            return $this->mapper->toArray($category);
        });
    }

    #[McpTool(name: 'list_categories', description: 'List enabled catalog categories')]
    public function listCategories(): array 
    {
        return $this->execute(
            fn() => $this->mapper->manyToArray($this->categories->findAllEnabled())
        );
    }

    #[McpTool(name: 'get_category_by_code', description: 'Get a category by code')]
    public function getCategoryByCode(string $code): array
    {
        return $this->execute(function () use ($code): array {
            $category = $this->categories->findOneByCode($code);

            if (!$category instanceof Category) {
                throw new \RuntimeException('Category not found');
            }

            return $this->mapper->toArray($category);
        });
    }
}