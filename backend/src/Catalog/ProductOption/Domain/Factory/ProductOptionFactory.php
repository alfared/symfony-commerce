<?php

namespace App\Catalog\ProductOption\Domain\Factory;

use App\Catalog\ProductOption\Domain\Model\ProductOption;
use App\Catalog\ProductOption\Domain\Model\ProductOptionValue;

final class ProductOptionFactory implements ProductOptionFactoryInterface
{
    public function createOption(string $code, string $name): ProductOption
    {
        $option = new ProductOption();

        $option->setCode($code);
        $option->setName($name);

        return $option;
    }

    public function createValue(
        ProductOption $option,
        string $code,
        string $value,
    ): ProductOptionValue {
        $optionValue = new ProductOptionValue();

        $optionValue->setCode($code);
        $optionValue->setValue($value);
        $optionValue->setOption($option);

        return $optionValue;
    }
}