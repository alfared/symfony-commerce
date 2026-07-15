<?php

namespace App\Catalog\Category\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Catalog\Category\Infrastructure\Api\UpdateCategoryAction;
use App\Catalog\Category\Infrastructure\Api\GetCategoriesAction;
use App\Catalog\Category\Infrastructure\Api\GetCategoryAction;
use App\Catalog\Category\Infrastructure\Api\GetCategoryByCodeAction;
use App\Catalog\Product\Domain\Model\Product;
use App\Catalog\Category\Infrastructure\Api\CreateCategoryAction;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'category')]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/categories',
            controller: GetCategoriesAction::class,
            read: false,
            name: 'get_categories',
        ),
        new Get(
            uriTemplate: '/categories/{id}',
            controller: GetCategoryAction::class,
            read: false,
            name: 'get_category'
        ),
        new Get(
            uriTemplate: '/categories/by-code/{code}',
            controller: GetCategoryByCodeAction::class,
            read: false,
            name: 'get_category_by_code'
        ),
        new Post(
            uriTemplate: '/categories',
            controller: CreateCategoryAction::class,
            read: false,
            deserialize: false,
            name: 'create_category',
        ),
        new Put(
            uriTemplate: '/categories/{id}',
            controller: UpdateCategoryAction::class,
            read: false,
            deserialize: false,
            name: 'update_category',
        )
    ]
)]
class Category 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, unique: true)]
    private string $code;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    private string $slug;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private bool $enabled = true;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getCode(): string { return $this->code; }
    public function setCode(string $code): void { $this->code = $code; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getSlug(): string { return $this->slug; }
    public function setSlug(string $slug): void { $this->slug = $slug; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): void { $this->description = $description; }

    public function isEnabled(): bool { return $this->enabled; }
    public function setEnabled(bool $enabled): void { $this->enabled = $enabled; }
    public function getProducts(): Collection { return $this->products; }
    public function addProduct(Product $product): void 
    {
        if ($this->products->contains($product)) {
            return;
        }

        $this->products->add($product);
        $product->changeCategory($this);
    }
    public function removeProduct(Product $product): void
    {
        if (!$this->products->removeElement($product)) {
            return;
        }

        if ($product->category() === $this) {
            $product->changeCategory(null);
        }
    }
}