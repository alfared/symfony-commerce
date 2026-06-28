<?php

namespace App\Catalog\Category\Infrastructure\Api;

use App\Catalog\Category\Application\CreateCategoryCommand;
use App\Catalog\Category\Application\CreateCategoryHandler;
use App\Catalog\Caterory\Domain\Model\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class CreateCategoryAction
{
    public function __construct(
        private CreateCategoryHandler $handler,
    ){
    }

    public function __invoke(Request $request): Category|JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        $category = ($this->handler)(new CreateCategoryCommand(
            code: (string) $data['code'],
            name: (string) $data['name'],
            slug: (string) $data['slug'],
            description: $data['description'] ?? null,
            enabled: $data['enabled'] ?? true,
        ));

        return new JsonResponse([
            'id' => $category->getId(),
            'code' => $category->getCode(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription(),
            'enabled' => $category->isEnabled(),
        ], 201);
    }
}