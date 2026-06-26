<?php

namespace App\Catalog\Product\Api;

use App\Catalog\Product\Application\CreateProductCommand;
use App\Catalog\Product\Application\CreateProductHandler;
use App\Catalog\Product\Model\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class CreateProductAction
{
    public function __construct(
        private CreateProductHandler $handler,
    ){
    }

    public function __invoke(Request $request): Product|JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        return ($this->handler)(new CreateProductCommand(
            code: (string) $data['code'],
            name: (string) $data['name'],
            slug: (string) $data['slug'],
            description: $data['description'] ?? null,
            enabled: $data['enabled'] ?? true,
        ));
    }
}