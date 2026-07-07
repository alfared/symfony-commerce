<?php

namespace App\Agent\Shared\Tool;

final readonly class ToolResponse
{
    public function __construct(
        public bool $success,
        public mixed $data = null,
        public ?string $error = null,
    ) {
    }

    public static function success(mixed $data = null): array
    {
        return [
            'success' => true,
            'data' => $data,
            'error' => null,
        ];
    }

    public static function error(string $message): array
    {
        return [
            'success' => false,
            'data' => null,
            'error' => $message,
        ];
    }
}