<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Api;

use App\Catalog\Manufacturer\Application\Query\GetManufacturerHandler;
use App\Catalog\Manufacturer\Application\Query\GetManufacturerQuery;
use App\Catalog\Manufacturer\Domain\Exception\ManufacturerNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/manufacturers/{id}',
    name: 'api_manufacturers_get',
    methods: ['GET'],
)]
final readonly class GetManufacturerAction
{
    
}