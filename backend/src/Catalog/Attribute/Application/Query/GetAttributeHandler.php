<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application\Query;

use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use App\Catalog\Attribute\Application\Query\AttributeView;

final readonly class GetAttributeHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    } 

    public function __invoke(GetAttributeQuery $query): AttributeView
    {
        $id = new AttributeId($query->id);

        $attribute = $this->attributes->findById($id);

        if ($attribute === null) {
            throw AttributeNotFound::withId($query->id);
        }

        return AttributeView::fromAggregate($attribute);
    }
}