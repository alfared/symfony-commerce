<?php

namespace App\Catalog\ProductOption\Api;

use App\Catalog\ProductOption\Application\CreateProductOptionCommand;
use App\Catalog\ProductOption\Application\CreateProductOptionHandler;
use App\Catalog\ProductOption\Model\ProductOption;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class CreateProductOptionAction
{
    public function __construct(
        private CreateProductOptionHandler $handler,
    ) {
    }

    public function __invoke(Request $request): ProductOption|JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        $option = ($this->handler)(new CreateProductOptionCommand(
            code: (string) $data['code'],
            name: (string) $data['name'],
        ));

        return new JsonResponse([
            'id' => $option->getId(),
            'code' => $option->getCode(),
            'name' => $option->getName(),
        ], 201);
    }
}