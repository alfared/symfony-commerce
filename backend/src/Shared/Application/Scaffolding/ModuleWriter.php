<?php

namespace App\Shared\Application\Scaffolding;

use Symfony\Component\Filesystem\Filesystem;

final readonly class ModuleWriter
{
    public function __construct(
        private Filesystem $filesystem,
    ){
    }

    public function write(ModuleExecutionPlan $plan): void
    {
        foreach ($plan->files as $file) {
            if ($file->action === ModuleExecutionAction::Skip) {
                continue;
            }

            $this->filesystem->dumpFile($file->targetPath, $file->content);
        }
    }
}