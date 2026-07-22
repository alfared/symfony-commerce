<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Exception\AttributeNotFound;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;

final readonly class DeleteAttributeHandler
{
    public function __construct(
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    public function __invoke(DeleteAttributeCommand $command): void
    {
        $id = new AttributeId($command->id);

        $attribute = $this->attributes->findById($id);

        if ($attribute === null) {
            throw AttributeNotFound::withId($command->id);
        }

        $this->attributes->remove($attribute);
    }
}