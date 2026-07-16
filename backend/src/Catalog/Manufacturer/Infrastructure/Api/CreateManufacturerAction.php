<?php

namespace App\Catalog\Manufacturer\Infrastructure\Api;

use App\Catalog\Manufacturer\Application\CreateManufacturerCommand;
use App\Catalog\Manufacturer\Application\CreateManufacturerHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class CreateManufacturerAction
{
    public function __construct(
        private CreateManufacturerHandler $handler,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
             return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        $manufacturer = ($this->handler)(new CreateManufacturerCommand(
            code: (string) $data['code'],
            name: (string) $data['name'],
            slug: (string) $data['slug'],
            description: $data['description'] ?? null,
            enabled: (bool) ($data['enabled'] ?? true),
        ));

        return new JsonResponse([
            'id' => $manufacturer->getId(),
            'code' => $manufacturer->getCode(),
            'name' => $manufacturer->getName(),
            'slug' => $manufacturer->getSlug(),
            'description' => $manufacturer->getDescription(),
            'enabled' => $manufacturer->isEnabled(),
        ], 201);
    }
}