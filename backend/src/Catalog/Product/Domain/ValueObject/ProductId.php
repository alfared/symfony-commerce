<?php

namespace App\Catalog\Product\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

final readonly class ProductId
{
    public function __construct(
        private string $value,
    ) {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException('Invalid product id.');
        }
    }

    public static function new(): self
    {
         return new self((string) Uuid::v7());
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