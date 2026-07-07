<?php

namespace App\Agent\Shared\Dto;

final readonly class AgentResponse
{
    public function __construct(
        public bool $success,
        public mixed $data = null,
        public ?string $error = null,
    ){
    }

    public static function success(mixed $data = null): self
    {
        return new self(true, $data);
    }

    public static function error(string $message): self
    {
        return new self(false, null, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
            'error' => $this->error,
        ];
    }
}