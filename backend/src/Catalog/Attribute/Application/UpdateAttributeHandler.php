<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use App\Catalog\Attribute\Domain\ValueObject\AttributeName;
use App\Catalog\Attribute\Domain\ValueObject\AttributeType;
use Dom\Attr;

final readonly class UpdateAttributeHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    public function __invoke(UpdateAttributeCommand $command): void
    {
        $id = new AttributeId($command->id);

        $attribute = $this->attributes->findById($id);

        if ($attribute === null) {
            throw AttributeNotFound::withId($command->id);
        }

        $attribute->update(
            name: new AttributeName($command->name),
            type: AttributeType::from($command->type),
            required: $command->required,
            filterable: $command->filterable,
            searchable: $command->searchable,
            variantAxis: $command->variantAxis,
            enabled: $command->enabled
        );

        $this->attributes->save($attribute);
    }
}