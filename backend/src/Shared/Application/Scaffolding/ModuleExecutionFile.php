<?php

namespace App\Shared\Application\Scaffolding;

final readonly class ModuleExecutionFile
{
    public function __construct(
        public string $targetPath,
        public string $content,
        public ModuleExecutionAction $action,
    ) {
    }
}