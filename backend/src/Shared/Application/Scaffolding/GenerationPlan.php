<?php

namespace App\Shared\Application\Scaffolding;

final readonly class GenerationPlan
{
    /**
     * @param GeneratedFile[] $files
     */
    public function __construct(
        public GenerationContext $context,
        public array $files,
    ){
    }
}