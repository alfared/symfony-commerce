<?php

namespace App\Shared\Application\Scaffolding;

final readonly class TemplateRenderer
{
    public function render(GenerationPlan $plan): GenerationPlan
    {
        $files = [];

        foreach ($plan->files as $file) {
            if (!file_exists($file->templatePath)) {
                continue;
            }

            $files[] = new GeneratedFile(
                templatePath: $file->templatePath,
                targetPath: $file->targetPath,
                variables: [
                    'content' => strtr(
                        file_get_contents($file->templatePath),
                        $file->variables
                    ),
                ],
            );
        }

        return new GenerationPlan($plan->context, $files);
    }
}