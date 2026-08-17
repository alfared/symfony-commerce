<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Entity\AttributeOption;
use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use App\Catalog\Attribute\Domain\ValueObject\AttributeName;

final readonly class AddAttributeOptionHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    public function __invoke(AddAttributeOptionCommand $command): string
    {
        $attribute = $this->attributes->findById(new AttributeId($command->attributeId));

        if ($attribute === null) {
            throw AttributeNotFound::withId($command->attributeId);
        }

        $option = AttributeOption::create(
            code: new AttributeCode($command->code),
            name: new AttributeName($command->name),
            sortOrder: $command->sortOrder,
        );

        $attribute->addOption($option);

        $this->attributes->save($attribute);

        return $option->id();

    }
}