<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;

final readonly class DeleteAttributeOptionHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    public function __invoke(DeleteAttributeOptionCommand $command): void
    {
        $attribute = $this->attributes->findById(new AttributeId($command->attributeId));

        if ($attribute === null) {
            throw new AttributeNotFound($command->attributeId);
        }

        $removed = $attribute->removeOptionById($command->optionId);

        if (!$removed) {
            throw new \DomainException(sprintf(
                'Attribute option with id "%s" was not found.',
                $command->optionId,
            ));
        }

        $this->attributes->save($attribute);

    }
}