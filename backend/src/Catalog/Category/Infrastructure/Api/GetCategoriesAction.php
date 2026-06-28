<?php

namespace App\Catalog\Category\Infrastructure\Api;

use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class GetCategoriesAction
{
    public function __construct(
      private CategoryRepositoryInterface $categories,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(array_map(
            fn (Category $category): array => $this->normalize($category),
            $this->categories->findAllEnabled(),
        ));
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