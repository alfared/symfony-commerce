<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\DeleteAttributeOptionCommand;
use App\Catalog\Attribute\Application\DeleteAttributeOptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes/{attributeId}/options/{optionId}',
    name: 'api_attribute_option_delete',
    methods: ['DELETE'],
)]
final readonly class DeleteAttributeOptionAction
{
    public function __construct(
        private DeleteAttributeOptionHandler $handler,
    ) {
    }

     public function __invoke(
        string $attributeId,
        string $optionId,
    ): JsonResponse {
        try {
            ($this->handler)(new DeleteAttributeOptionCommand(
                attributeId: $attributeId,
                optionId: $optionId,
            ));
            
            return new JsonResponse(
                null,
                JsonResponse::HTTP_NO_CONTENT,
            );

        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST,
            );
        } catch (\DomainException $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
    }
}