<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Application\Query;

use App\Catalog\Manufacturer\Domain\Model\Manufacturer;

final readonly class ManufacturerView
{
    public function __construct(
        public string $id,
        public string $code,
        public string $name,
        public string $slug,
        public bool $enabled,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }

    public static function fromAggregate(Manufacturer $manufacturer): self
    {
        return new self(
            id: $manufacturer->id()->value(),
            code: $manufacturer->code()->value(),
            name: $manufacturer->name()->value(),
            slug: $manufacturer->slug()->value(),
            enabled: $manufacturer->enabled(),
            createdAt: $manufacturer->createdAt()->format(DATE_ATOM),
            updatedAt: $manufacturer->updatedAt()->format(DATE_ATOM),
        );
    }

     /**
     * @return array{
     *     id: string,
     *     code: string,
     *     name: string,
     *     slug: string,
     *     enabled: bool,
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
            'slug' => $this->slug,
            'enabled' => $this->enabled,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}