<?php

namespace App\Catalog\Product\Application;

use App\Catalog\Product\Domain\Factory\ProductFactoryInterface;
use App\Catalog\Product\Domain\Model\Product;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateProductHandler
{
    public function __construct(
        private ProductFactoryInterface $productFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateProductCommand $command): Product
    {
        $product = $this->productFactory->createWithData(
            code: $command->code,
            name: $command->name,
            slug: $command->slug,
            description: $command->description,
            active: $command->active,
        );

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}