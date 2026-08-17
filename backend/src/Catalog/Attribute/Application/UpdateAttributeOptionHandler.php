<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use App\Catalog\Attribute\Domain\ValueObject\AttributeName;

final readonly class UpdateAttributeOptionHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    public function __invoke(UpdateAttributeOptionCommand $command): void
    {
        $attribute = $this->attributes->findById(
            new AttributeId($command->attributeId),
        );

        if ($attribute === null) {
            throw AttributeNotFound::withId($command->attributeId);
        } 

        $option = $attribute->findOptionById($command->optionId);
        
        if ($option === null) {
              throw new \DomainException(sprintf(
                'Attribute option with id "%s" was not found.',
                $command->optionId,
            ));
        }

        $option->rename(new AttributeName($command->name));
        $option->changeSortOrder($command->sortOrder);
        $command->enabled ? $option->enable() : $option->disable();
        $this->attributes->save($attribute);
    }
}