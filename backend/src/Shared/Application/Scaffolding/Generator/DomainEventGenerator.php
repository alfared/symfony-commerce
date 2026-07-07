<?php

namespace App\Shared\Application\Scaffolding\Generator;

use App\Shared\Application\Scaffolding\GeneratedFile;
use App\Shared\Application\Scaffolding\GenerationContext;
use App\Shared\Application\Scaffolding\GenerationPlan;
use App\Shared\Application\Scaffolding\GeneratorInterface;

final readonly class DomainEventGenerator implements GeneratorInterface
{
    public function __construct(
        private string $backendDir,
    ) {
    }

    public function type(): string
    {
        return 'event';
    }

    public function generate(GenerationContext $context): GenerationPlan
    {
        $className = $context->className();
        $contextPath = $context->directoryPath();

        return new GenerationPlan($context, [
            new GeneratedFile(
                $this->backendDir.'/templates/scaffolding/domain-event.php.tpl',
                $this->backendDir."/src/{$contextPath}/Domain/Event/{$className}.php",
                [
                    '{{ ClassName }}' => $className,
                    '{{ Namespace }}' => 'App\\'.$context->namespacePath().'\\Domain\\Event',
                ],
            ),
        ]);
    }
}