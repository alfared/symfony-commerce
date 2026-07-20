<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;

use App\Shared\Domain\ValueObject\Code;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

abstract class CodeType extends StringType
{
    /**
     * @return class-string<Code>
     */
    abstract protected function valueObjectClass(): string;

    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?Code {
        if ($value === null) {
            return null;
        }

        $class = $this->valueObjectClass();

        if ($value instanceof $class) {
            return $value;
        }

        return new $class((string) $value);
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?string {
        if ($value === null) {
            return null;
        }

        $class = $this->valueObjectClass();

        if (!$value instanceof $class) {
            throw new \InvalidArgumentException(sprintf(
                'Expected %s, got %s.',
                $class,
                get_debug_type($value),
            ));
        }

        return $value->value();
    }

    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform,
    ): string {
        return $platform->getStringTypeDeclarationSQL([
            ...$column,
            'length' => $column['length'] ?? 64,
            'fixed' => false,
        ]);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}