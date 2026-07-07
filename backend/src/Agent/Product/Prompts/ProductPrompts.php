<?php

namespace App\Agent\Product\Prompts;

use App\Agent\Shared\Base\AbstractPrompt;
use App\Agent\Shared\Contract\PromptInterface;
use App\Agent\Shared\Prompt\PromptBuilder;
use Mcp\Capability\Attribute\McpPrompt;

final readonly class ProductPrompts extends AbstractPrompt implements PromptInterface
{
    #[McpPrompt(
        name: 'generate_product_description',
        description: 'Generate an SEO-friednly product description'
    )]
    public function generateProductDescription(
        string $productName,
        string $categoryName,
        string $tone = 'professional',
    ): array {
        return $this->user(<<<PROMPT

        Generate an SEO-friendly product description.

        Product name: {$productName}
        Category: {$categoryName}
        Tone: {$tone}

        Return:
        - short description
        - long description
        - SEO meta title
        - SEO meta description
        PROMPT);
    }

    #[McpPrompt(
        name: 'generate_product_slug',
        description: 'Generate a URL-friendly product slug'
    )]
    public function generateProductSlug(string $productName): array
    {
        return $this->user(<<<PROMPT
        Generate a URL-friendly slug for this product:

        Product name: {$productName}

        Rules:
        - lowercase
        - words separated by hyphens
        - no special characters
        - no trailing hyphen
        PROMPT);
    }
}