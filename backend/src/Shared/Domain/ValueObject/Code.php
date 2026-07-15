<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract readonly class Code
{
    final public function __construct(
        protected string $value,
    ) {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException('Code cannot be empty.');
        }

        if (mb_strlen($value) > 64) {
            throw new \InvalidArgumentException(
                'Code cannot be longer than 64 characters.',
            );
        }

        if (!preg_match('/^[a-z0-9_]+$/', $value)) {
            throw new \InvalidArgumentException(
                'Code must contain only lowercase letters, numbers and underscores.',
            );
        }

        $this->value = $value;
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