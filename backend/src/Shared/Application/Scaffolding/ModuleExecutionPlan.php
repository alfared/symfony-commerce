<?php

namespace App\Shared\Application\Scaffolding;

final readonly class ModuleExecutionPlan
{
    /**
     * @param ModuleExecutionFile[] $files
     */
    public function __construct(
        public GenerationContext $context,
        public array $files,
    ) {
    }
}