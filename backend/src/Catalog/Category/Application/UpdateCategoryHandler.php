<?php

namespace App\Catalog\Category\Application;

use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;

final readonly class UpdateCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categories,
    ) {
    }

    public function __invoke(UpdateCategoryCommand $command)
    {
        $category = $this->categories->findById($command->id);

        if ($category == null) {
            throw new \RuntimeException('Category not found');
        }

        if ($command->code !== null) {
            $category->setCode($command->code);
        }

        if ($command->name !== null) {
            $category->setName($command->name);
        }

        if ($command->slug !== null) {
            $category->setSlug($command->slug);
        }

        if ($command->description !== null) {
            $category->setDescription($command->description);
        }

        if ($command->enabled !== null) {
            $category->setEnabled($command->enabled);
        }

        $this->categories->save($category);

        return $category;
    }
}