<?php

namespace App\Catalog\Category\Application;

use App\Catalog\Category\Domain\Factory\CategoryFactoryInterface;
use App\Catalog\Category\Domain\Model\Category;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateCategoryHandler
{
    public function __construct (
        private CategoryFactoryInterface $categoryFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateCategoryCommand $command): Category
    {
        $category = $this->categoryFactory->createWithData(
            code: $command->code,
            name: $command->name,
            slug: $command->slug,
            description: $command->description,
            enabled: $command->enabled,
        );

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}