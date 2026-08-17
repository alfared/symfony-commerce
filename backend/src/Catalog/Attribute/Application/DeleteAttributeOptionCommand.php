<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\AttributeOptionId;

final readonly class DeleteAttributeOptionCommand
{
    public function __construct(
        public string $attributeId,
        public string $optionId,
    ) {
    }
}