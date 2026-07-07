<?php

namespace App\{{ Context }}\{{ Entity }}\Infrastructure\Api;

use App\{{ Context }}\{{ Entity }}\Application\Create{{ Entity }}Command;
use App\{{ Context }}\{{ Entity }}\Application\Create{{ Entity }}Handler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class Create{{ Entity }}Action
{
    public function __construct(
        private Create{{ Entity }}Handler $handler,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
             return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        ${{ entity }} = ($this->handler)(new Create{{ Entity }}Command(
            code: (string) $data['code'],
            name: (string) $data['name'],
            slug: (string) $data['slug'],
            description: $data['description'] ?? null,
            enabled: (bool) ($data['enabled'] ?? true),
        ));

        return new JsonResponse([
            'id' => ${{ entity }}->getId(),
            'code' => ${{ entity }}->getCode(),
            'name' => ${{ entity }}->getName(),
            'slug' => ${{ entity }}->getSlug(),
            'description' => ${{ entity }}->getDescription(),
            'enabled' => ${{ entity }}->isEnabled(),
        ], 201);
    }
}