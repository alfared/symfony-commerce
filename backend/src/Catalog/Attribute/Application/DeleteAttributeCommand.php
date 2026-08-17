<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

final readonly class DeleteAttributeCommand
{
    public function __construct(
        public string $id,
    ) {
    }
}