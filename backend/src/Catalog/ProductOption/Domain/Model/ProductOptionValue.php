<?php

namespace App\Catalog\ProductOption\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Catalog\ProductOption\Domain\Model\ProductOption;
use App\Catalog\ProductOption\Infrastructure\Api\CreateProductOptionValueAction;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: '/product-option-values',
            controller: CreateProductOptionValueAction::class,
            read: false,
            deserialize: false,
            output: ProductOptionValue::class,
            name: 'create_product_option_value',
        )
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: 'catalog_product_option_value')]
class ProductOptionValue
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, unique: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(targetEntity: ProductOption::class, inversedBy: 'values')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductOption $option = null;

    public function getId(): ?int { return $this->id; }

    public function getCode(): ?string { return $this->code; }

    public function setCode(?string $code): void { $this->code = $code; }

    public function getValue(): ?string { return $this->value; }

    public function setValue(?string $value): void { $this->value = $value; }

    public function getOption(): ?ProductOption { return $this->option; }

    public function setOption(?ProductOption $option): void { $this->option = $option; }
}