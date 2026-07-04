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
    name: 'commerce:make:agent-module',
    description: 'Generate Agent MCP module skeleton'
)]
final class MakeAgentModuleCommand extends Command
{
    public function __construct(
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('entity', InputArgument::REQUIRED, 'Entity name, e.g. Brand')
             ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite existing files')
             ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Show files without writing them');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entity = ucfirst((string) $input->getArgument('entity'));
        $baseDir = $this->projectDir . '/src/Agent/' . $entity;
        $force = (bool) $input->getOption('force');
        $dryRun = (bool) $input->getOption('dry-run');

        $fs = new Filesystem();

        $fs->mkdir([
            $baseDir . '/Tools',
            $baseDir . '/Resources',
            $baseDir . '/Prompts',
        ]);

        $this->dump($fs, $baseDir . "/Tools/{$entity}Tools.php", $this->toolsTemplate($entity), $force, $dryRun, $output);
        $this->dump($fs, $baseDir . "/Resources/{$entity}Resources.php", $this->resourcesTemplate($entity), $force, $dryRun, $output);
        $this->dump($fs, $baseDir . "/Prompts/{$entity}Prompts.php", $this->promptsTemplate($entity), $force, $dryRun, $output);
        $this->dump($fs, $this->projectDir . "/src/Agent/Shared/Dto/{$entity}Dto.php", $this->dtoTemplate($entity), $force, $dryRun, $output);
        $this->dump($fs, $this->projectDir . "/src/Agent/Shared/Mapper/{$entity}Mapper.php", $this->mapperTemplate($entity), $force, $dryRun, $output);

        $output->writeln("<info>Agent module for {$entity} generated.</info>");

        return Command::SUCCESS;
    }

    private function dump(
        Filesystem $fs, 
        string $path, 
        string $content,
        bool $force,
        bool $dryRun,
        OutputInterface $output
    ): void
    {
        if (!$fs->exists($path) && !$force) {
            $output->writeln("<comment>Skipped existing:</comment> {$path}");
            return;
        }

        if ($dryRun) {
            $output->writeln("<info>Would write:</info> {$path}");
            return;
        }

        $fs->dumpFile($path, $content);
        $output->writeln("<info>Written: </info> {$path}");
    }

    private function toolsTemplate(string $entity): string
    {
        $snake = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $entity));

        return <<<PHP
<?php

namespace App\\Agent\\{$entity}\\Tools;

use App\\Agent\\Shared\\Base\\AbstractTool;
use App\\Agent\\Shared\\Contract\\ToolInterface;
use Mcp\\Capability\\Attribute\\McpTool;

final readonly class {$entity}Tools extends AbstractTool implements ToolInterface
{
    #[McpTool(name: 'list_{$snake}s', description: 'List {$entity} records')]
    public function list{$entity}s(): array
    {
        return \$this->execute(fn (): array => [
            'message' => '{$entity} agent tool generated. Implement repository integration.',
        ]);
    }
}

PHP;
    }

    private function resourcesTemplate(string $entity): string
    {
        $snake = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $entity));

        return <<<PHP
<?php

namespace App\\Agent\\{$entity}\\Resources;

use App\\Agent\\Shared\\Base\\AbstractResource;
use App\\Agent\\Shared\\Contract\\ResourceInterface;
use Mcp\\Capability\\Attribute\\McpResource;

final readonly class {$entity}Resources extends AbstractResource implements ResourceInterface
{
    #[McpResource(
        uri: '{$snake}://list',
        name: '{$snake}_list',
        description: 'List {$entity} records'
    )]
    public function list{$entity}s(): array
    {
        return \$this->collection([]);
    }
}

PHP;
    }

    private function promptsTemplate(string $entity): string
    {
        $snake = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $entity));

        return <<<PHP
<?php

namespace App\\Agent\\{$entity}\\Prompts;

use App\\Agent\\Shared\\Base\\AbstractPrompt;
use App\\Agent\\Shared\\Contract\\PromptInterface;
use Mcp\\Capability\\Attribute\\McpPrompt;

final readonly class {$entity}Prompts extends AbstractPrompt implements PromptInterface
{
    #[McpPrompt(
        name: 'generate_{$snake}_description',
        description: 'Generate {$entity} description'
    )]
    public function generate{$entity}Description(string \$name, string \$tone = 'professional'): array
    {
        return \$this->user(<<<PROMPT
Generate a description for {$entity}.

Name: {\$name}
Tone: {\$tone}
PROMPT);
    }
}

PHP;
    }

    private function dtoTemplate(string $entity): string
    {
        return <<<PHP
<?php

namespace App\\Agent\\Shared\\Dto;

final readonly class {$entity}Dto
{

    public function __construct(
        public int \$id,
        public string \$code,
        public string \$name,
        public ?string \$description = null,
        public bool \$enabled = true,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars(\$this);
    }
}

PHP;
    }

    private function mapperTemplate(string $entity): string
    {
        return <<<PHP
<?php

namespace App\\Agent\\Shared\\Mapper;

use App\\Agent\\Shared\\Dto\\{$entity}Dto;

final readonly class {$entity}Mapper
{
    public function toArray(object \$entity): array
    {
        if (!method_exists(\$entity, 'getId')){
            throw new \\InvalidArgumentException('Invalid entity object.');
        }

        return new {$entity}Dto(
            id: \$entity->getId(),
            code: method_exists(\$entity, 'getCode') ? \$entity->getCode() : '',
            name: method_exists(\$entity, 'getName') ? \$entity->getName() : '',
            description: method_exists(\$entity, 'getDescription') ? \$entity->getDescription() : null,
            enabled: method_exists(\$entity, 'isEnabled') ? \$entity->isEnabled() : true,
        )->toArray();
    }

    public function manyToArray(array \$items): array
    {
        return array_map(fn (object \$item): array => \$this->toArray(\$item), \$items);
    }
}

PHP;
    }
}