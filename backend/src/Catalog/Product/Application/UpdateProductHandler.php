<?php

namespace App\Catalog\Product\Application;

use App\Catalog\Product\Domain\Repository\ProductRepositoryInterface;

final readonly class UpdateProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $categories,
    ) {
    }

    public function __invoke(UpdateProductCommand $command)
    {
        $product = $this->products->findById($command->id);

        if ($product == null) {
            throw new \RuntimeException('Product not found');
        }

        if ($command->code !== null) {
            $product->setCode($command->code);
        }

        if ($command->name !== null) {
            $product->setName($command->name);
        }

        if ($command->slug !== null) {
            $product->setSlug($command->slug);
        }

        if ($command->description !== null) {
            $product->setDescription($command->description);
        }

        if ($command->active !== null) {
            $product->setActive($command->active);
        }

        $this->products->save($product);

        return $product;
    }
}