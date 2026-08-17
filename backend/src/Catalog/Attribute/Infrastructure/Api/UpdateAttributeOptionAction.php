<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\UpdateAttributeOptionCommand;
use App\Catalog\Attribute\Application\UpdateAttributeOptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes/{attributeId}/options/{optionId}',
    name: 'api_attribute_option_update',
    methods: ['PATCH'],
)]
final readonly class UpdateAttributeOptionAction
{
    public function __construct(
        private UpdateAttributeOptionHandler $handler,
    ) {
    }

    public function __invoke( 
        string $attributeId,
        string $optionId,
        Request $request): JsonResponse 
    {
        try {
            $data = $request->toArray();

            ($this->handler)(new UpdateAttributeOptionCommand(
                attributeId: $attributeId,
                optionId: $optionId,
                name: $data['name'],
                sortOrder: $data['sort_order'],
                enabled: $data['enabled'],
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
        }  
        catch (\DomainException $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
    }
}