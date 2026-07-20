<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application;

use App\Catalog\Attribute\Domain\Factory\AttributeFactory;
use App\Catalog\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;

final readonly class CreateAttributeHandler
{
    public function __construct(
        private AttributeFactory $factory,
        private AttributeRepositoryInterface $attributes,
    ) {
    }

    public function __invoke(CreateAttributeCommand $command): string
    {
        $code = new AttributeCode($command->code);

        if ($this->attributes->exists($code)) {
            throw new \DomainException(sprintf(
                'Attribute with code "%s" already exists.',
                $command->code,
            ));
        }

        $attribute = $this->factory->create(
            code: $command->code,
            name: $command->name,
            type: $command->type,
        );

        if ($command->required) {
            $attribute->markAsRequired();
        }

        if ($command->filterable) {
            $attribute->markAsFilterable();
        }

        if ($command->searchable) {
            $attribute->markAsSearchable();
        }

        if ($command->variantAxis) {
            $attribute->markAsVariantAxis();
        }

        $this->attributes->save($attribute);

        return $attribute->id()->value();
    }
}