<?php

namespace App\Agent\Shared\Base;

use App\Agent\Shared\Prompt\PromptBuilder;

abstract readonly class AbstractPrompt 
{
    protected function user(string $text): array
    {
        return PromptBuilder::user($text);
    }

    protected function system(string $text): array
    {
        return PromptBuilder::system($text);
    }
}