<?php

namespace App\Shared\Application\Scaffolding;

interface GeneratorInterface
{
    public function type(): string;
    
    public function generate(GenerationContext $context): GenerationPlan;
}