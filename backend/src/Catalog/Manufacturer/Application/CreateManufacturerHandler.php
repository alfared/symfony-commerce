<?php

namespace App\Catalog\Manufacturer\Application;

use App\Catalog\Manufacturer\Domain\Factory\ManufacturerFactory;
use App\Catalog\Manufacturer\Domain\Repository\ManufacturerRepositoryInterface;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerCode;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerSlug;

final readonly class CreateManufacturerHandler
{
    public function __construct(
        private ManufacturerFactory $factory,
        private ManufacturerRepositoryInterface $manufacturers,
    ) {
    }

    public function __invoke(CreateManufacturerCommand $command): string
    {
        $code = new ManufacturerCode($command->code);
        $slug = new ManufacturerSlug($command->slug);

        if ($this->manufacturers->existsByCode($code)) {
            throw new \DomainException(sprintf(
                'Manufacturer with code "%s" already exists.',
                $command->code,
            ));
        }

        if ($this->manufacturers->existsBySlug($slug)) {
            throw new \DomainException(sprintf(
                'Manufacturer with slug "%s" already exists.',
                $command->slug,
            ));
        }

        $manufacturer = $this->factory->create(
            code: $command->code,
            name: $command->name,
            slug: $command->slug,
        );

        $this->manufacturers->save($manufacturer);

        return $manufacturer->id()->value();
    }
}