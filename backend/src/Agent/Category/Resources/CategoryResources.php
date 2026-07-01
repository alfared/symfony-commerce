<?php

namespace App\Agent\Category\Resources;

use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Mcp\Capability\Attribute\McpResource;

final readonly class CategoryResources
{
     public function __construct(
        private CategoryRepositoryInterface $categories,
    ) {
    }

    #[McpResource(
        uri: 'category://list',
        name: 'Category list',
        description: 'List enabled catalog categories'
    )]
    public function listCategories(): array 
    {
        return array_map(
            fn (Category $category): array => [
                'id' => $category->getId(),
                'code' => $category->getCode(),
                'name' => $category->getName(),
                'slug' => $category->getSlug(),
                'description' => $category->getDescription(),
                'enabled' => $category->isEnabled(),
            ],
            $this->categories->findAllEnabled(),
        );
    }
}