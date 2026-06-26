<?php

namespace App\Catalog\ProductVariant\Application;

use App\Catalog\Product\Model\Product;
use App\Catalog\Product\Repository\ProductRepository;
use App\Catalog\ProductVariant\Factory\ProductVariantFactoryInterface;
use App\Catalog\ProductVariant\Model\ProductVariant;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateProductVariantHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductVariantFactoryInterface $variantFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateProductVariantCommand $command): ProductVariant
    {
        $product = $this->productRepository->find($command->productId);

        if (!$product instanceof Product) {
            throw new \InvalidArgumentException('Product not found.');
        }

        $variant = $this->variantFactory->createWithData(
            product: $product,
            code: $command->code,
            sku: $command->sku,
            price: $command->price,
            stock: $command->stock,
            enabled: $command->enabled,
        );

        $this->entityManager->persist($variant);
        $this->entityManager->flush();

        return $variant;
    }
}
