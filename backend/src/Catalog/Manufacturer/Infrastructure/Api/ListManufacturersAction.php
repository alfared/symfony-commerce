<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Api;

use App\Catalog\Manufacturer\Application\Query\ListManufacturersHandler;
use App\Catalog\Manufacturer\Application\Query\ManufacturerView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/manufacturers',
    name: 'api_manufacturers_list', 
    methods: ['GET'],
)]
final readonly class ListManufacturersAction
{
    public function __construct(
        private ListManufacturersHandler $listManufacturers,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        /** @var list<ManufacturerView> $manufacturers */
        $manufacturers = ($this->listManufacturers)();

        return new JsonResponse(
            array_map(
                static fn (ManufacturerView $manufacturer): array =>
                    $manufacturer->toArray(),
                $manufacturers,
            ),
        );
    }
}