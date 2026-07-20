<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Api;

use App\Catalog\Attribute\Application\CreateAttributeCommand;
use App\Catalog\Attribute\Application\CreateAttributeHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/attributes',
    name: 'api_attribute_create',
    methods: ['POST'],
)]
final readonly class CreateAttributeAction
{
    public function __construct(
        private CreateAttributeHandler $handler,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** @var array<string, mixed> $data */
            $data = $request->toArray();

            $id = ($this->handler)(new CreateAttributeCommand(
                code: $this->requiredString($data, 'code'),
                name: $this->requiredString($data, 'name'),
                type: $this->requiredString($data, 'type'),
                required: (bool) ($data['required'] ?? false),
                filterable: (bool) ($data['filterable'] ?? false),
                searchable: (bool) ($data['searchable'] ?? false),
                variantAxis: (bool) ($data['variantAxis'] ?? false),
            ));

            return new JsonResponse(
                data: ['id' => $id],
                status: JsonResponse::HTTP_CREATED,
            );
        } catch (\InvalidArgumentException|\ValueError|\DomainException $exception) {
            return new JsonResponse(
                data: [
                    'error' => $exception->getMessage(),
                ],
                status: JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
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