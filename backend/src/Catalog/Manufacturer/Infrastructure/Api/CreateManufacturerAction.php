<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Api;

use App\Catalog\Manufacturer\Application\CreateManufacturerCommand;
use App\Catalog\Manufacturer\Application\CreateManufacturerHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/manufacturers',
    name: 'api_manufacturer_create',
    methods: ['POST'],
)]
final readonly class CreateManufacturerAction
{
    public function __construct(
        private CreateManufacturerHandler $handler,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** @var array<string, mixed> $data */
            $data = $request->toArray();

            $id = ($this->handler)(new CreateManufacturerCommand(
                code: $this->requiredString($data, 'code'),
                name: $this->requiredString($data, 'name'),
                slug: $this->requiredString($data, 'slug'),
            ));

            return new JsonResponse(
                data: ['id' => $id],
                status: JsonResponse::HTTP_CREATED,
            );

        } catch (\InvalidArgumentException|\DomainException $exception) {
            return new JsonResponse(
                data: ['error' => $exception->getMessage()],
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