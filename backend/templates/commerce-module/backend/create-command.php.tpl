<?php

namespace App\{{ Context }}\{{ Entity }}\Application;

final readonly class Create{{ Entity }}Command
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