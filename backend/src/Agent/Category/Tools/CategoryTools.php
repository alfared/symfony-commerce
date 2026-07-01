<?php

namespace App\Agent\Catalog;

use App\Catalog\Category\Application\CreateCategoryCommand;
use App\Catalog\Category\Application\CreateCategoryHandler;
use App\Catalog\Category\Application\UpdateCategoryCommand;
use App\Catalog\Category\Application\UpdateCategoryHandler;
use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Mcp\Capability\Attribute\McpTool;

final readonly class CategoryTools
{
    public function __construct(
        private CreateCategoryHandler $createCategory,
        private UpdateCategoryHandler $updateCategory,
        private CategoryRepositoryInterface $categories,
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
       $category = ($this->createCategory)(new CreateCategoryCommand(
            code: $code,
            name: $name,
            slug: $slug,
            description: $description,
            enabled: $enabled,
       ));

       return $this->normalize($category);
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
        $category = ($this->updateCategory)(new updateCategoryCommand(
            id: $id,
            code: $code,
            name: $name,
            slug: $slug,
            description: $description,
            enabled: $enabled
        ));

        return $this->normalize($category);
    }

    #[McpTool(name: 'list_categories', description: 'List enabled catalog categories')]
    public function listCategories(): array 
    {
        return array_map(
            fn (Category $category): array => $this->normalize($category),
            $this->categories->findAllEnabled(),
        );
    }

    #[McpTool(name: 'get_category_by_code', description: 'Get a category by code')]
    public function getCategoryByCode(string $code): array
    {
        $category = $this->categories->findOneByCode($code);

        if (!$category instanceof Category) {
            return ['error' => 'Category not found'];
        }

        return $this->normalize($category);
    }

    private function normalize(Category $category): array 
    {
        return [
            'id' => $category->getId(),
            'code' => $category->getCode(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription(),
            'enabled' => $category->isEnabled(),
        ];
    }
}