<?php

namespace App\Catalog\Manufacturer\Application;

final readonly class CreateManufacturerCommand
{
    public function __construct(
        public string $code,
        public string $name,
        public string $slug,
    ){
    }
}