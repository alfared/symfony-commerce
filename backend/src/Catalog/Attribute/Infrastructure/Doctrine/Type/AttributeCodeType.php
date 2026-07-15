<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Doctrine\Type;

use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Shared\Infrastructure\Doctrine\Type\CodeType;

final class AttributeCodeType extends CodeType
{
    public const NAME = 'attribute_code';

    protected function valueObjectClass(): string
    {
        return AttributeCode::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}