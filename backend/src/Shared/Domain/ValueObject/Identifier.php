<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

abstract readonly class Identifier
{
    final public function __construct(
        protected string $value,
    ) {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid identifier "%s".',
                $value,
            ));
        }
    }

    final public static function new(): static
    {
        return new static((string) Uuid::v7());
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(self $other): bool
    {
        return $this::class === $other::class
            && $this->value === $other->value;
    }

    final public function __toString(): string
    {
        return $this->value;
    }
}