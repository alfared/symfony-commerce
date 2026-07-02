<?php

namespace App\Agent\Category\Prompts;

use App\Agent\Shared\Base\AbstractPrompt;
use App\Agent\Shared\Contract\PromptInterface;
use App\Agent\Shared\Prompt\PromptBuilder;
use Mcp\Capability\Attribute\McpPrompt;

final readonly class CategoryPrompts extends AbstractPrompt implements PromptInterface
{
    #[McpPrompt(
        name: 'generate_category_description',
        description: 'Generate an SEO-friendly category description'
    )]
    public function generateCategoryDescription(
        string $categoryName,
        string $tone = 'professional'
    ): array {
        return $this->user(<<<PROMPT

        Generate an SEO-friendly category description.
        Category name: {$categoryName}
        Tone: {$tone}

        Return:
        - short description
        - long description
        - SEO meta title
        - SEO meta description
        PROMPT);
    }
}