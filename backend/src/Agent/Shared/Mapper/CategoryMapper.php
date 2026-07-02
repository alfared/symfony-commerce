<?php

namespace App\Agent\Shared\Mapper;

use App\Agent\Shared\Dto\CategoryDto;
use App\Catalog\Category\Domain\Model\Category;

final readonly class CategoryMapper
{
    public function toDto(Category $category): CategoryDto
    {
        return new CategoryDto(
            id: $category->getId(),
            code: $category->getCode(),
            name: $category->getName(),
            slug: $category->getSlug(),
            description: $category->getDescription(),
            enabled: $category->isEnabled(),
        );
    }

    public function toArray(Category $category): array
    {
        return $this->toDto($category)->toArray();
    }

    /**
     * @param Category[] $categories
     */
    public function manyToArray(array $categories): array
    {
        return array_map(
            fn (Category $category): array => $this->toArray($category),
            $categories
        );
    }
}