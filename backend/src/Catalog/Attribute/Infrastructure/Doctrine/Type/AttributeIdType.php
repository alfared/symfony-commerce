<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Doctrine\Type;

use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use App\Shared\Infrastructure\Doctrine\Type\IdentifierType;


final class AttributeIdType extends IdentifierType
{
    public const NAME = 'attribute_id';

    protected function valueObjectClass(): string
    {
        return AttributeId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}