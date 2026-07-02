<?php

namespace App\Agent\Shared\Prompt;

final readonly class PromptBuilder
{
    public static function user(string $text): array
    {
        return [
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => $text,
                    ],
                ],
            ],
        ];
    }
}