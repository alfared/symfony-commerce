<?php

namespace App\Shared\Application\Scaffolding;

final readonly class ModulePlanner
{
    public function plan(GenerationPlan $plan): ModuleExecutionPlan
    {
        $files = [];

        foreach ($plan->files as $file) {
            $targetPath = $file->targetPath;
            $exists = file_exists($targetPath);

            $action = match (true) {
                !$exists => ModuleExecutionAction::Create,
                $plan->context->force => ModuleExecutionAction::Overwrite,
                default => ModuleExecutionAction::Skip,
            };

            $files[] = new ModuleExecutionFile(
                targetPath: $targetPath,
                content: $file->variables['content'] ?? '',
                action: $action,
            );
        }

        return new ModuleExecutionPlan($plan->context, $files);
    }
}