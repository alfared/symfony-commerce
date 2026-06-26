<?php

namespace App\Catalog\ProductVariant\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Catalog\Product\Domain\Model\Product;
use App\Catalog\ProductOption\Domain\Model\ProductOptionValue;
use App\Catalog\ProductVariant\Infrastructure\Doctrine\ProductVariantRepository;
use App\Catalog\ProductVariant\Infrastructure\Api\CreateProductVariantAction;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/product-variants',
            controller: CreateProductVariantAction::class,
            deserialize: false,
            name: 'create_product_variant'
        ),
    ]
)]
#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
class ProductVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $code = null;

    #[ORM\Column(length: 128)]
    private ?string $sku = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'variants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToMany(targetEntity: ProductOptionValue::class)]
    #[ORM\JoinTable(name: 'catalog_product_variant_option_value')]
    private Collection $optionValues;

    public function __construct()
    {
        $this->optionValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOptionValues(): Collection
    {
        return $this->optionValue;
    }

    public function addOptionValue(ProductOptionValue $optionValue): void
    {
        if (!$this->optionValues->contains($optionValue)) {
            $this->optionValues->add($optionValue);
        }
    }

    public function removeOptionValue(ProductOptionValue $optionValue): void
    {
        $this->optionValues->removeElement($optionValue);
    }
}
