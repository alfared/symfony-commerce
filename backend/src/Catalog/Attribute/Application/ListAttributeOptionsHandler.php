<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;

final readonly class ListAttributeOptionsHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function __invoke(string $attributeId): array
    {
        $attribute = $this->attributes->findById(
            new AttributeId($attributeId),
        );

        if ($attribute === null) {
            throw AttributeNotFound::withId($attributeId);
        }

        return array_map(
            static fn ($option): array => [
                'id' => $option->id(),
                'code' => $option->code()->value(),
                'name' => $option->name()->value(),
                'sortOrder' => $option->sortOrder(),
                'enabled' => $option->enabled(),
            ],
            $attribute->options(),
        );
    }
}