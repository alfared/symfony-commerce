<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Application\Query;

use App\Catalog\Attribute\Domain\Model\Attribute;

final readonly class AttributeView
{
    /**
     * @param list<array{
     *     id: string,
     *     code: string,
     *     name: string,
     *     sortOrder: int,
     *     enabled: bool
     * }> $options
     */
    public function __construct(
        public string $id,
        public string $code,
        public string $name,
        public string $type,
        public bool $required,
        public bool $filterable,
        public bool $searchable,
        public bool $variantAxis,
        public bool $enabled,
        public array $options,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }

    public static function fromAggregate(Attribute $attribute): self
    {
        $options = [];

        foreach ($attribute->options() as $option) {
            $options[] = [
                'id' => $option->id()->value(),
                'code' => $option->code()->value(),
                'name' => $option->name()->value(),
                'sortOrder' => $option->sortOrder(),
                'enabled' => $option->enabled(),
            ];
        }

        return new self(
            id: $attribute->id()->value(),
            code: $attribute->code()->value(),
            name: $attribute->name()->value(),
            type: $attribute->type()->value,
            required: $attribute->required(),
            filterable: $attribute->filterable(),
            searchable: $attribute->searchable(),
            variantAxis: $attribute->variantAxis(),
            enabled: $attribute->enabled(),
            options: $options,
            createdAt: $attribute->createdAt()->format(DATE_ATOM),
            updatedAt: $attribute->updatedAt()->format(DATE_ATOM),
        );
    }

    /**
     * @return array{
     *     id: string,
     *     code: string,
     *     name: string,
     *     type: string,
     *     required: bool,
     *     filterable: bool,
     *     searchable: bool,
     *     variantAxis: bool,
     *     enabled: bool,
     *     options: list<array{
     *         id: string,
     *         code: string,
     *         name: string,
     *         sortOrder: int,
     *         enabled: bool
     *     }>,
     *     createdAt: string,
     *     updatedAt: string
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'required' => $this->required,
            'filterable' => $this->filterable,
            'searchable' => $this->searchable,
            'variantAxis' => $this->variantAxis,
            'enabled' => $this->enabled,
            'options' => $this->options,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}