<?php

namespace App\Shared\Application\Scaffolding;

final readonly class GenerationContext
{
    public function __construct(
        public string $type,
        public string $name,
        public string $context,
        public bool $force = false,
    ){
    }

    public function className(): string
    {
        return ucfirst($this->name);
    }

    public function contextName(): string
    {
        return ucfirst($this->context);
    }

    public function namespacePath(): string
    {
        return str_replace('/', '\\', $this->contextName());
    }

    public function directoryPath(): string
    {
        return str_replace('\\', '/', $this->contextName());
    }

}