<?php

namespace App\Catalog\Brand\Infrastructure\Api;

use App\Catalog\Brand\Application\CreateBrandCommand;
use App\Catalog\Brand\Application\CreateBrandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class CreateBrandAction
{
    public function __construct(
        private CreateBrandHandler $handler,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
             return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        $brand = ($this->handler)(new CreateBrandCommand(
            code: (string) $data['code'],
            name: (string) $data['name'],
            slug: (string) $data['slug'],
            description: $data['description'] ?? null,
            enabled: (bool) ($data['enabled'] ?? true),
        ));

        return new JsonResponse([
            'id' => $brand->getId(),
            'code' => $brand->getCode(),
            'name' => $brand->getName(),
            'slug' => $brand->getSlug(),
            'description' => $brand->getDescription(),
            'enabled' => $brand->isEnabled(),
        ], 201);
    }
}