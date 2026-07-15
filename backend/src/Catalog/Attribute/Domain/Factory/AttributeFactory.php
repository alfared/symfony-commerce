<?php

namespace App\Catalog\Attribute\Domain\Factory;

use App\Catalog\Attribute\Domain\Model\Attribute;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Catalog\Attribute\Domain\ValueObject\AttributeName;
use App\Catalog\Attribute\Domain\ValueObject\AttributeType;

final readonly class AttributeFactory
{
    public function create(
        string $code,
        string $name,
        string $type
    ): Attribute {
        return Attribute::create(
            code: new AttributeCode($code),
            name: new AttributeName($name),
            type: AttributeType::from($type),
        );
    }
}