<?php

namespace App\Shared\Application\Scaffolding;

final readonly class GeneratedFile
{
    public function __construct(
        public string $templatePath,
        public string $targetPath,
        public array $variables = [],
    ) {
    }
}