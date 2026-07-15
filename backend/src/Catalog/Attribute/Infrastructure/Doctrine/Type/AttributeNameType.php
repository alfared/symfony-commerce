<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Doctrine\Type;

use App\Catalog\Attribute\Domain\ValueObject\AttributeName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class AttributeNameType extends StringType
{
    public const NAME = 'attribute_name';

    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?AttributeName {
        if ($value === null || $value instanceof AttributeName) {
            return $value;
        }

        return new AttributeName((string) $value);
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?string {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof AttributeName) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected %s, got %s.',
                    AttributeName::class,
                    get_debug_type($value),
                ),
            );
        }

        return $value->value();
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}