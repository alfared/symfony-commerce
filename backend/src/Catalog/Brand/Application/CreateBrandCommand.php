<?php

namespace App\Catalog\Brand\Application;

final readonly class CreateBrandCommand
{
    public function __construct(
        public string $code,
        public string $name,
        public string $slug,
        public ?string $description = null,
        public bool $enabled = true,
    ){
    }
}