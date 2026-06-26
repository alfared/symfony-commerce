<?php

namespace App\Catalog\ProductOption\Factory;

use App\Catalog\ProductOption\Model\ProductOption;
use App\Catalog\ProductOption\Model\ProductOptionValue;

interface ProductOptionFactoryInterface
{
    public function createOption(string $code, string $name): ProductOption;

    public function createValue(
        ProductOption $option,
        string $code,
        string $value,
    ): ProductOptionValue;
}