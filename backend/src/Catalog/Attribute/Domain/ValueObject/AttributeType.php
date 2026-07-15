<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Domain\ValueObject;

enum AttributeType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Boolean = 'boolean';
    case Integer = 'integer';
    case Decimal = 'decimal';
    case Date = 'date';
    case Select = 'select';
    case MultiSelect = 'multi_select';

    public function hasOptions(): bool
    {
        return match ($this) {
            self::Select,
            self::MultiSelect => true,

            default => false,
        };
    }
}