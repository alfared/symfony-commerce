<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract readonly class Slug
{
    protected string $value;

    final public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException(
                'Slug cannot be empty.',
            );
        }

        if (mb_strlen($value) > 255) {
            throw new \InvalidArgumentException(
                'Slug cannot be longer than 255 characters.',
            );
        }

        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value)) {
            throw new \InvalidArgumentException(
                'Invalid slug.',
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