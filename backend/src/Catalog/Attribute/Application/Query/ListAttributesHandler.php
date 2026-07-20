<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application\Query;

use App\Catalog\Attribute\Domain\Model\Attribute;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;

final readonly class ListAttributesHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    /**
     * @return list<AttributeView>
     */
    public function __invoke(): array
    {
        return array_map(
            static fn (Attribute $attribute): AttributeView =>
                AttributeView::fromAggregate($attribute),
            $this->attributes->findAll(),
        );
    }
}