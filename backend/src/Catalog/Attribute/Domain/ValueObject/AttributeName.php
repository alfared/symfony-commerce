<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Domain\ValueObject;

final readonly class AttributeName
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException(
                'Attribute name cannot be empty.',
            );
        }

        if (mb_strlen($value) > 255) {
            throw new \InvalidArgumentException(
                'Attribute name cannot be longer than 255 characters.',
            );
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}