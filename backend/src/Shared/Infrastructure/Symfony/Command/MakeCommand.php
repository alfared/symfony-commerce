<?php

namespace App\Shared\Infrastructure\Symfony\Command;

use App\Shared\Application\Scaffolding\GenerationContext;
use App\Shared\Application\Scaffolding\GeneratorRegistry;
use App\Shared\Application\Scaffolding\ModulePlanner;
use App\Shared\Application\Scaffolding\ModuleWriter;
use App\Shared\Application\Scaffolding\TemplateRenderer;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'commerce:make',
    description: 'Generate DDD scaffolding artifacts'
)]
final class MakeCommand extends Command
{
    public function __construct(
        private readonly GeneratorRegistry $registry,
        private readonly TemplateRenderer $renderer,
        private readonly ModulePlanner $planner,
        private readonly ModuleWriter $writer,

    ) {
         parent::__construct();
    } 

    protected function configure(): void
    {
        $this
            ->addArgument('type', InputArgument::REQUIRED, 'aggregate, value-object, event')
            ->addArgument('name', InputArgument::REQUIRED, 'Class/module name')
            ->addArgument('context', InputArgument::REQUIRED, 'Context path, e.g. Catalog or Catalog/Product')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite existing files')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Preview files without writing them');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $generationContext = new GenerationContext(
            type: (string) $input->getArgument('type'),
            name: (string) $input->getArgument('name'),
            context: (string) $input->getArgument('context'),
            force: (bool) $input->getOption('force'),
        );

        $generator = $this->registry->get($generationContext->type);

        $generationPlan = $generator->generate($generationContext);
        $renderedPlan = $this->renderer->render($generationPlan);
        $executionPlan = $this->planner->plan($renderedPlan);

        foreach ($executionPlan->files as $file) {
            $output->writeln(sprintf(
                '<info>[%s]</info> %s',
                $file->action->value,
                $file->targetPath,
            ));
        }

        if (!$input->getOption('dry-run')) {
            $this->writer->write($executionPlan);
        }

        return Command::SUCCESS;
    }
}