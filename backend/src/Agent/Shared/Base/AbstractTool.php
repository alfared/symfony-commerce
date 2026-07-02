<?php

namespace App\Agent\Shared\Base;

use App\Agent\Shared\Tool\ToolResponse;

abstract readonly class AbstractTool 
{
    protected function execute(callable $callback): array
    {
        try {
            return ToolResponse::success(
                $callback()
            );
        } catch (\Throwable $exception) {
            return ToolResponse::error(
                $exception->getMessage()
            );
        }
    }
}