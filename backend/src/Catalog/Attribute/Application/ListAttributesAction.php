<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\Query\ListAttributesHandler;
use App\Catalog\Attribute\Application\Query\AttributeView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes',
    name: 'api_attributes_list',
    methods: ['GET'],
)]
final readonly class ListAttributesAction
{
    public function __construct(
         private ListAttributesHandler $handler,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $attributes = ($this->handler)();

       return new JsonResponse(
        array_map(
            static fn (AttributeView $attribute): array =>
                $attribute->toArray(),
            $attributes,
        ),
    );
    }
}