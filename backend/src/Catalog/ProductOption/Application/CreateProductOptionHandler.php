<?php

namespace App\Catalog\ProductOption\Application;

use App\Catalog\ProductOption\Factory\ProductOptionFactoryInterface;
use App\Catalog\ProductOption\Model\ProductOption;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateProductOptionHandler
{
    public function __construct(
        private ProductOptionFactoryInterface $factory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateProductOptionCommand $command): ProductOption
    {
        $option = $this->factory->createOption(
            code: $command->code,
            name: $command->name,
        );

        $this->entityManager->persist($option);
        $this->entityManager->flush();

        return $option;
    }
}