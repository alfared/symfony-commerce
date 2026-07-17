<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Infrastructure\Doctrine\Type;

use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Override;

final class ManufacturerNameType extends StringType
{
    public const NAME = 'manufacturer_name';

   
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?ManufacturerName
    {
        if ($value === null || $value instanceof ManufacturerName) {
            return $value;
        }

        return new ManufacturerName((string) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof ManufacturerName) {
            throw new \InvalidArgumentException(sprintf(
                'Expected %s, got %s.',
                ManufacturerName::class,
                get_debug_type($value),
            ));
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