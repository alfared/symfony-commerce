<?php

namespace App\Shared\Application\Scaffolding;

enum ModuleExecutionAction: string
{
    case Create = 'create';
    case Overwrite = 'overwrite';
    case Skip = 'skip';
}