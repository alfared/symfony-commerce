<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Domain\Exception;

use RuntimeException;

final class AttributeNotFound extends RuntimeException
{
    public static function withId(string $id): self
    {
        return new self(sprintf(
            'Attribute with id "%s" was not found.',
            $id,
        ));
    }
}