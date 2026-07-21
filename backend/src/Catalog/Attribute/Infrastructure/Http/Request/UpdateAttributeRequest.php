<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Infrastructure\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateAttributeRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: [
            'text',
            'textarea',
            'number',
            'boolean',
            'date',
            'select',
            'multi_select',
        ])]
        public string $type,

        public bool $required = false,
        public bool $filterable = false,
        public bool $searchable = false,
        public bool $variantAxis = false,
        public bool $enabled = true,
    )
    {}
}