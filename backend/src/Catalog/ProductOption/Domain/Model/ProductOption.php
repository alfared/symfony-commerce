<?php

namespace App\Catalog\ProductOption\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Catalog\ProductOption\Infrastructure\Api\CreateProductOptionAction;
use App\Catalog\ProductOption\Infrastructure\Doctrine\ProductOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: '/product-options',
            controller: CreateProductOptionAction::class,
            read: false,
            deserialize: false,
            output: ProductOption::class,
            name: 'create_product_option',
        ),
    ]
)]
#[ORM\Entity(repositoryClass: ProductOptionRepository::class)]
#[ORM\Table(name: 'catalog_product_option')]
class ProductOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, unique: true)]
    private ?string $code = null;

     #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(
        mappedBy: 'option',
        targetEntity: ProductOptionValue::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getCode(): ?string { return $this->code; }

    public function setCode(?string $code): void { $this->code = $code; }

    public function getName(): ?string { return $this->name; }

    public function setName(?string $name): void { $this->name = $name; }

    public function getValues(): Collection { return $this->values; }

    public function addValue(ProductOptionValue $value): void
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
            $value->setOption($this);
        }
    }

    public function removeValue(ProductOptionValue $value): void
    {
        if ($this->values->removeElement($value)) {
            $value->setOption(null);
        }
    }
}