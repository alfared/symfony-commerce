<?php

namespace App\Agent\ProductVariant\Prompts;

use App\Agent\Shared\Base\AbstractPrompt;
use App\Agent\Shared\Contract\PromptInterface;
use Mcp\Capability\Attribute\McpPrompt;

final readonly class ProductVariantPrompts extends AbstractPrompt implements PromptInterface
{
    #[McpPrompt(
        name: 'generate_product_variant_sku',
        description: 'Generate a SKU for a product variant'
    )]
    public function generateProductVariankSku(
        string $productCode,
        string $variantName,
    ): array {
        return $this->user(<<<PROMPT
            Generate a clean SKU for this product variant.

            Product code: {$productCode}
            Variant name: {$variantName}

            Rules:
            - uppercase
            - words separated by hyphens
            - no spaces
            - no special characters except hyphen
        PROMPT);
    }
}