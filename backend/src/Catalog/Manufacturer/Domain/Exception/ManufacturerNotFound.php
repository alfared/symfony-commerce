<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Domain\Exception;

final class ManufacturerNotFound extends \DomainException
{
    public static function withId(string $id): self
    {
        return new self(sprintf(
            'Manufacturer with id "%s" was not found.',
            $id,
        ));
    }
}