<?php

namespace App\Shared\Infrastructure\Symfony\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'commerce:make:module',
    description: 'Generate DDD + React module skeleton'
)]
final class MakeCommerceModuleCommand extends Command
{
    public function __construct(
        private readonly string $backendDir,
         private readonly string $frontendDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('entity', InputArgument::REQUIRED, 'Entity name, e.g. Brand')
            ->addArgument('context', InputArgument::REQUIRED, 'Bounded context, e.g. Catalog')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite existing files')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Show files without writing them');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entity = ucfirst((string) $input->getArgument('entity'));
        $context = ucfirst((string) $input->getArgument('context'));
        $force = (bool) $input->getOption('force');
        $dryRun = (bool) $input->getOption('dry-run');


        $entitySnake = $this->snake($entity);
        $entityKebab = str_replace('_' , '-', $entitySnake);
        $entities = $entitySnake . 's';

        $variables = [
            '{{ Entity }}' => $entity,
            '{{ entity }}' => $entitySnake,
            '{{ entityKebab }}' => $entityKebab,
            '{{ entities }}' => $entities,
            '{{ Context }}' => $context,
            '{{ context }}' => strtolower($context),
        ];

        $files = [
            "templates/commerce-module/backend/entity.php.tpl" 
                => $this->backendDir . "/src/{$context}/{$entity}/Domain/Model/{$entity}.php",
            
            "templates/commerce-module/backend/factory.php.tpl"
                =>  $this->backendDir . "/src/{$context}/{$entity}/Domain/Factory/{$entity}Factory.php",

            "templates/commerce-module/backend/repository-interface.php.tpl"
                => $this->backendDir . "/src/{$context}/{$entity}/Domain/Repository/{$entity}RepositoryInterface.php",

            "templates/commerce-module/backend/repository.php.tpl"
                => $this->backendDir . "/src/{$context}/{$entity}/Infrastructure/Doctrine/{$entity}Repository.php",
            
            "templates/commerce-module/backend/create-command.php.tpl"
                => $this->backendDir . "/src/{$context}/{$entity}/Application/Create{$entity}Command.php",

            "templates/commerce-module/backend/create-handler.php.tpl"
                => $this->backendDir . "/src/{$context}/{$entity}/Application/Create{$entity}Handler.php",

            "templates/commerce-module/backend/create-action.php.tpl" 
                => $this->backendDir . "/src/{$context}/{$entity}/Infrastructure/Api/Create{$entity}Action.php",

            "templates/commerce-module/frontend/type.ts.tpl"
                => $this->frontendDir . "/src/entities/{$entityKebab}/model/{$entityKebab}.ts",
            
            "templates/commerce-module/frontend/dto.ts.tpl"
                => $this->frontendDir . "/src/entities/{$entityKebab}/model/{$entityKebab}.dto.ts",

            "templates/commerce-module/frontend/api.ts.tpl"
                => $this->frontendDir . "/src/entities/{$entityKebab}/api/{$entity}Api.ts",

            "templates/commerce-module/frontend/list.tsx.tpl"
                => $this->frontendDir . "/src/entities/{$entityKebab}/ui/{$entity}List.tsx",

            "templates/commerce-module/frontend/create-form.tsx.tpl"
                => $this->frontendDir . "/src/features/{$entityKebab}/create/Create{$entity}Form.tsx",
            
            "templates/commerce-module/frontend/management.tsx.tpl"
                => $this->frontendDir . "/src/widgets/{$entityKebab}-management/{$entity}Management.tsx"
            
        ];

        $fs = new Filesystem();

        foreach ($files as $template => $target) {
            $templatePath = $this->backendDir . '/' . $template;

            if (!$fs->exists($templatePath)) {
                $output->writeln("<comment>Missing template:</comment> {$templatePath}");
                continue;
            }

            $content = strtr(file_get_contents($templatePath), $variables);

            if ($fs->exists($target) && !$force) {
                $output->writeln("<comment>Skipped existing:</comment> {$target}");
                continue;
            }

            if ($dryRun) {
                $output->writeln("<info>Would write:</info> {$target}");
                continue;
            }

            $fs->dumpFile($target, $content);
            $output->writeln("<info>Written:</info> {$target}");
        }

        return Command::SUCCESS;
    }

    private function snake(string $value): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }
}