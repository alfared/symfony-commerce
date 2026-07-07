<?php

namespace App\Shared\Application\Scaffolding\Generator;

use App\Shared\Application\Scaffolding\GeneratedFile;
use App\Shared\Application\Scaffolding\GenerationContext;
use App\Shared\Application\Scaffolding\GenerationPlan;
use App\Shared\Application\Scaffolding\GeneratorInterface;

final readonly class AggregateGenerator implements GeneratorInterface
{
    public function __construct(
        private string $backendDir,
        private string $frontendDir,
    ) {
    }

    public function type(): string
    {
        return 'aggregate';
    }

    public function generate(GenerationContext $context): GenerationPlan
    {
        $entity = $context->className();
        $boundedContext = $context->contextName();

        $entitySnake = strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $entity));
        $entityKebab = str_replace('_', '-', $entitySnake);

        $variables = [
            '{{ Entity }}' => $entity,
            '{{ entity }}' => $entitySnake,
            '{{ entityKebab }}' => $entityKebab,
            '{{ entities }}' => $entitySnake.'s',
            '{{ Context }}' => $boundedContext,
            '{{ context }}' => strtolower($boundedContext),
        ];

        return new GenerationPlan($context, [
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/entity.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Domain/Model/{$entity}.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/factory.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Domain/Factory/{$entity}Factory.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/repository-interface.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Domain/Repository/{$entity}RepositoryInterface.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/repository.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Infrastructure/Doctrine/{$entity}Repository.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/create-command.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Application/Create{$entity}Command.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/create-handler.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Application/Create{$entity}Handler.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/backend/create-action.php.tpl',
                $this->backendDir."/src/{$boundedContext}/{$entity}/Infrastructure/Api/Create{$entity}Action.php",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/frontend/type.ts.tpl',
                $this->frontendDir."/src/entities/{$entityKebab}/model/{$entityKebab}.ts",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/frontend/dto.ts.tpl',
                $this->frontendDir."/src/entities/{$entityKebab}/model/{$entityKebab}.dto.ts",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/frontend/api.ts.tpl',
                $this->frontendDir."/src/entities/{$entityKebab}/api/{$entity}Api.ts",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/frontend/list.tsx.tpl',
                $this->frontendDir."/src/entities/{$entityKebab}/ui/{$entity}List.tsx",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/frontend/create-form.tsx.tpl',
                $this->frontendDir."/src/features/{$entityKebab}/create/Create{$entity}Form.tsx",
                $variables,
            ),
            new GeneratedFile(
                $this->backendDir.'/templates/commerce-module/frontend/management.tsx.tpl',
                $this->frontendDir."/src/widgets/{$entityKebab}-management/{$entity}Management.tsx",
                $variables,
            ),
        ]);
    }
}