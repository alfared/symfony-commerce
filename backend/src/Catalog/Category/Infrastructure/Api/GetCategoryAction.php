<?php

namespace App\Catalog\Category\Infrastructure\Api;

use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class GetCategoryAction
{
    public function __construct(
        private CategoryRepositoryInterface $categories,
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        $category = $this->categories->findById($id);

        if (!$category instanceof Category) {
            return new JsonResponse(['error' => 'Category not found'], 404);
        }

        return new JsonResponse([
            'id' => $category->getId(),
            'code' => $category->getCode(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription(),
            'enabled' => $category->isEnabled(),
        ]);
    }
}