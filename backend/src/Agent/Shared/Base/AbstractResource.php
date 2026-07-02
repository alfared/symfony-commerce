<?php

namespace App\Agent\Shared\Base;

use App\Agent\Shared\Resource\ResourceResponse;

abstract readonly class AbstractResource
{
    protected function collection(array $data): array
    {
        return ResourceResponse::collection($data);
    }

    protected function item(array $data): array
    {
        return ResourceResponse::item($data);
    }
}