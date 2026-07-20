<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Model\Attribute;
use App\Catalog\Attribute\Infrastructure\Doctrine\AttributeRepository;

final readonly class ListAttributesHandler
{
    public function __construct(
        private AttributeRepository $attributes,
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function __invoke(): array
    {
        /** @var Attribute[] $attributes */
        $attributes = $this->attributes->findBy(
            [],
            ['createdAt' => 'DESC'],
        );

        return array_map(
            static fn (Attribute $attribute): array => [
              'id' => $attribute->id()->value(),
              'code' => $attribute->code()->value(),
              'name' => $attribute->name()->value(),
              'filterable' => $attribute->filterable(),
              'searchable' => $attribute->searchable(),
              'variantAxis' => $attribute->variantAxis(),
              'enabled' => $attribute->enabled(),
              'options' => array_map(
                static fn ($option): array => [
                        'id' => $option->id(),
                        'code' => $option->code()->value(),
                        'name' => $option->name()->value(),
                        'sortOrder' => $option->sortOrder(),
                        'enabled' => $option->enabled(),
                    ],
                    $attribute->options(),
              ),
              'createdAt' => $attribute->createdAt()->format(DATE_ATOM),
              'updatedAt' => $attribute->updatedAt()->format(DATE_ATOM),
            ],
            $attributes,
        );
    }
}