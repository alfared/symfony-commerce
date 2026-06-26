<?php

namespace App\Catalog\ProductVariant\Api;

use App\Catalog\ProductVariant\Application\CreateProductVariantCommand;
use App\Catalog\ProductVariant\Application\CreateProductVariantHandler;
use App\Catalog\ProductVariant\Model\ProductVariant;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class CreateProductVariantAction
{
    public function __construct(
        private CreateProductVariantHandler $handler,
    ) {

    }

    public function __invoke(Request $request): JsonResponse
    {
         $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid JSON body'], 400);
        }

        $value = ($this->handler)(new CreateProductOptionValueCommand(
            optionId: (int) $data['optionId'],
            code: (string) $data['code'],
            value: (string) $data['value'],
        ));

         return new JsonResponse([
            'id' => $value->getId(),
            'code' => $value->getCode(),
            'value' => $value->getValue(),
            'optionId' => $value->getOption()?->getId(),
        ], 201);
    }
}