<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Http\Action;

use App\Catalog\Attribute\Application\UpdateAttributeCommand;
use App\Catalog\Attribute\Application\UpdateAttributeHandler;
use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Infrastructure\Http\Request\UpdateAttributeRequest;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class UpdateAttributeAction
{
    public function __construct(
        private UpdateAttributeHandler $handler,
    ) {
    }

    #[Route(
        path: '/api/attributes/{id}',
        name: 'api_attributes_update',
        methods: ['PATCH'],
    )]
    
    public function __invoke(
        string $id,
        #[MapRequestPayload] UpdateAttributeRequest $request,
    ): JsonResponse {
        try {
            ($this->handler)(new UpdateAttributeCommand(
                id: $id,
                name: $request->name,
                type: $request->type,
                required: $request->required,
                filterable: $request->filterable,
                searchable: $request->searchable,
                variantAxis: $request->variantAxis,
                enabled: $request->enabled,
            ));
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

        return new JsonResponse(
            data: null,
            status: JsonResponse::HTTP_NO_CONTENT,
        );
    }

}