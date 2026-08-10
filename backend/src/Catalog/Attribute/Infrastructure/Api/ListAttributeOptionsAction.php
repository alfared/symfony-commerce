<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\ListAttributeOptionsHandler;
use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes/{attributeId}/options',
    name: 'api_attribute_options_list',
    methods: ['GET'],
)]
final readonly class ListAttributeOptionsAction
{
    public function __construct(
        private ListAttributeOptionsHandler $handler,
    ) {
    }

    public function __invoke(string $attributeId): JsonResponse
    {
        try {
           return new JsonResponse(
                ($this->handler)($attributeId),
            );
        } catch ( \InvalidArgumentException $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST,
            );
        } catch (AttributeNotFound $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_NOT_FOUND,
            );
        } catch (\DomainException $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
    }
}