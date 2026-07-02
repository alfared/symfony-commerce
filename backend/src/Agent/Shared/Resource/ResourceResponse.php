<?php

namespace App\Agent\Shared\Resource;

final readonly class ResourceResponse
{
    public static function item(mixed $item): array
    {
        return [
            'type' => 'item',
            'data' => $item,
        ];
    }

    public static function collection(array $items): array
    {
        return [
            'type' => 'collection',
            'count' => count($items),
            'data' => $items,
        ];
    }
}