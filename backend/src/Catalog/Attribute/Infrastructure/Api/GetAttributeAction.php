<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\Query\GetAttributeHandler;
use App\Catalog\Attribute\Application\Query\GetAttributeQuery;
use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class GetAttributeAction
{
    public function __construct(
        private GetAttributeHandler $handler,
    ) {
    }

    #[Route(
        path: '/api/attributes/{id}',
        name: 'api_attributes_get',
        methods: ['GET'],
    )]
    public function __invoke(string $id): JsonResponse
    {
        try {
            $attribute = ($this->handler)(
                new GetAttributeQuery($id),
            );
            return new JsonResponse($attribute->toArray());
        } catch (AttributeNotFound $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_NOT_FOUND,
            );
        }
    }
}