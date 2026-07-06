<?php

namespace App\Catalog\Brand\Application;

use App\Catalog\Brand\Domain\Factory\BrandFactory;
use App\Catalog\Brand\Domain\Model\Brand;
use App\Catalog\Brand\Domain\Repository\BrandRepositoryInterface;

final readonly class CreateBrandHandler
{
    public function __construct(
        private BrandFactory $factory,
        private BrandRepositoryInterface $repository,
    ) {
    }

    public function __invoke(CreateBrandCommand $command): Brand
    {
        $brand = $this->factory->createWithData(
            code: $command->code,
            name: $command->name,
            slug: $command->slug,
            description: $command->description,
            enabled: $command->enabled,
        );

        $this->repository->save($brand);

        return $brand;
    }
}