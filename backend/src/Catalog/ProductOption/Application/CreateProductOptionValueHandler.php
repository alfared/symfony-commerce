<?php

namespace App\Catalog\ProductOption\Application;

use App\Catalog\ProductOption\Domain\Factory\ProductOptionFactoryInterface; 
use App\Catalog\ProductOption\Domain\Model\ProductOption; 
use App\Catalog\ProductOption\Domain\Model\ProductOptionValue; 
use App\Catalog\ProductOption\Infrastructure\Doctrine\ProductOptionRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateProductOptionValueHandler
{
    public function __construct(
        private ProductOptionRepository $optionRepository,
        private ProductOptionFactoryInterface $factory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateProductOptionValueCommand $command): ProductOptionValue
    {
        $option = $this->optionRepository->find($command->optionId);

        if (!$option instanceof ProductOption) {
            throw new \InvalidArgumentException('Product option not found.');
        }

        $value = $this->factory->createValue(
            option: $option,
            code: $command->code,
            value: $command->value,
        );

        $this->entityManager->persist($value);
        $this->entityManager->flush();

        return $value;
    }
}