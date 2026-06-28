<?php

namespace App\Catalog\Category\Infrastructure\Api;

use App\Catalog\Category\Application\UpdateCategoryCommand;
use App\Catalog\Category\Application\UpdateCategoryHandler;
use App\Catalog\Category\Domain\Model\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class UpdateCategoryAction
{
    public function __construct(
        private UpdateCategoryHandler $handler,
    ){
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        try {
            $category = ($this->handler)(new UpdateCategoryCommand(
                id: $id,
                code: $data['code'] ?? null,
                name: $data['name'] ?? null,
                slug: $data['slug'] ?? null,
                description: $data['description'] ?? null,
                enabled: array_key_exists('enabled', $data) ? (bool) $data['enabled'] : null,
            ));
        } catch (\RuntimeException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 404);
        }

        return new JsonResponse($this->normalize($category));
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