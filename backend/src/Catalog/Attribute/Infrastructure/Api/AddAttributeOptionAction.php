<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\AddAttributeOptionCommand;
use App\Catalog\Attribute\Application\AddAttributeOptionHandler;
use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes/{attributeId}/options',
    name: 'api_attribute_option_create',
    methods: ['POST'],
)]
final readonly class AddAttributeOptionAction
{
    public function __construct(
        private AddAttributeOptionHandler $handler,
    ) {
    }

    public function __invoke(
        string $attributeId,
        Request $request,
    ): JsonResponse {
        try {
          $data = $request->toArray();

          $id = ($this->handler)(new AddAttributeOptionCommand(
                attributeId: $attributeId,
                code: $this->requiredString($data, 'code'),
                name: $this->requiredString($data, 'name'),
                sortOrder: (int) ($data['sortOrder'] ?? 0),
          ));

          return new JsonResponse(
              ['id' => $id],
              JsonResponse::HTTP_CREATED,
          );
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
    }

    /**
     * @param array<string, mixed> $data
     */
    private function requiredString(array $data, string $field): string
    {
        $value = $data[$field] ?? null;

        if (!is_string($value) || trim($value) === '') {
            throw new \InvalidArgumentException(sprintf(
                'Field "%s" is required.',
                $field,
            ));
        }

        return $value;
    }
}