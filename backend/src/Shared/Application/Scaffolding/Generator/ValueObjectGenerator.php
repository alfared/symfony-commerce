<?php

namespace App\Shared\Application\Scaffolding\Generator;

use App\Shared\Application\Scaffolding\GeneratedFile;
use App\Shared\Application\Scaffolding\GenerationContext;
use App\Shared\Application\Scaffolding\GenerationPlan;
use App\Shared\Application\Scaffolding\GeneratorInterface;

final readonly class ValueObjectGenerator implements GeneratorInterface
{
    public function __construct(
        private string $backendDir,
    ) {
    }

    public function type(): string
    {
        return 'value-object';
    }

    public function generate(GenerationContext $context): GenerationPlan
    {
        $className = $context->className();
        $contextPath = $context->directoryPath();

        return new GenerationPlan($context, [
            new GeneratedFile(
                $this->backendDir.'/templates/scaffolding/value-object.php.tpl',
                $this->backendDir."/src/{$contextPath}/Domain/ValueObject/{$className}.php",
                [
                    '{{ ClassName }}' => $className,
                    '{{ Namespace }}' => 'App\\'.$context->namespacePath().'\\Domain\\ValueObject',
                ],
            ),
        ]);
    }
}