<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\ListAttributesHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes',
    name: 'api_attribute_list',
    methods: ['GET'],
)]
final readonly class ListAttributesAction
{
    public function __construct(
         private ListAttributesHandler $handler,
    ){
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(($this->handler)());
    }
}