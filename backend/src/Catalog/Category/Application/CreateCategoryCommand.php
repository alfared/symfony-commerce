<?php

namespace App\Catalog\Category\Application;

final readonly class CreateCategoryCommand
{
    public function __construct(
        public string $code,
        public string $name,
        public string $slug,
        public ?string $desription = null,
        public bool $enabled = true,
    ){
    }
}