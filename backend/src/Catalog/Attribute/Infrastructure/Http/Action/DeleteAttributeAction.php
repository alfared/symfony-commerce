<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Http\Action;

use App\Catalog\Attribute\Application\DeleteAttributeCommand;
use App\Catalog\Attribute\Application\DeleteAttributeHandler;
use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class DeleteAttributeAction
{
    public function __construct(
        private DeleteAttributeHandler $handler,
    ){}

    #[Route(
        path: '/api/attributes/{id}',
        name: 'api_attributes_delete',
        methods: ['DELETE'],
    )]
    public function __invoke(string $id): JsonResponse
    {
        try {
          ($this->handler)(new DeleteAttributeCommand(
            id: $id,
          ));
        } catch (\InvalidArgumentException $exception) {
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

        return new JsonResponse(
            data: null,
            status: JsonResponse::HTTP_NO_CONTENT,
        );
    }
}