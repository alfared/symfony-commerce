<?php

namespace {{ Namespace }};

final readonly class {{ ClassName }}
{
    public function __construct(
        private string $value,
    ) {
        if (trim($value) === '') {
            throw new \InvalidArgumentException('{{ ClassName }} cannot be empty.');
        }
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