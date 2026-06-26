<?php

namespace App\Catalog\ProductOption\Domain\Factory;

use App\Catalog\ProductOption\Domain\Model\ProductOption; 
use App\Catalog\ProductOption\Domain\Model\ProductOptionValue;

interface ProductOptionFactoryInterface
{
    public function createOption(string $code, string $name): ProductOption;

    public function createValue(
        ProductOption $option,
        string $code,
        string $value,
    ): ProductOptionValue;
}