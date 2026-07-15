<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Domain\Model;

use App\Catalog\Attribute\Domain\Entity\AttributeOption;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Catalog\Attribute\Domain\ValueObject\AttributeId;
use App\Catalog\Attribute\Domain\ValueObject\AttributeName;
use App\Catalog\Attribute\Domain\ValueObject\AttributeType;
use App\Catalog\Attribute\Infrastructure\Doctrine\AttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeRepository::class)]
#[ORM\Table(
    name: 'catalog_attributes',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'uniq_catalog_attribute_code',
            columns: ['code'],
        ),
    ],
)]
final class Attribute
{
    #[ORM\Id]
    #[ORM\Column(type: 'attribute_id', length: 36)]
    private AttributeId $id;

    #[ORM\Column(type: 'attribute_code', length: 64, unique: true)]
    private AttributeCode $code;

    #[ORM\Column(type: 'attribute_name', length: 255)]
    private AttributeName $name;

    #[ORM\Column(
        type: 'string',
        length: 32,
        enumType: AttributeType::class,
    )]
    private AttributeType $type;

    #[ORM\Column(type: 'boolean')]
    private bool $required;

    #[ORM\Column(type: 'boolean')]
    private bool $filterable;

    #[ORM\Column(type: 'boolean')]
    private bool $searchable;

    #[ORM\Column(name: 'variant_axis', type: 'boolean')]
    private bool $variantAxis;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled;

    /**
     * @var Collection<int, AttributeOption>
     */
    #[ORM\OneToMany(
        mappedBy: 'attribute',
        targetEntity: AttributeOption::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
    )]
    #[ORM\OrderBy(['sortOrder' => 'ASC'])]
    private Collection $options;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    private function __construct(
        AttributeId $id,
        AttributeCode $code,
        AttributeName $name,
        AttributeType $type,
    ) {
        $now = new \DateTimeImmutable();

        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->type = $type;
        $this->required = false;
        $this->filterable = false;
        $this->searchable = false;
        $this->variantAxis = false;
        $this->enabled = true;
        $this->options = new ArrayCollection();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public static function create(
        AttributeCode $code,
        AttributeName $name,
        AttributeType $type,
    ): self {
        return new self(
            id: AttributeId::new(),
            code: $code,
            name: $name,
            type: $type,
        );
    }

    public function rename(AttributeName $name): void
    {
        if ($this->name->equals($name)) {
            return;
        }

        $this->name = $name;
        $this->touch();
    }

    public function changeType(AttributeType $type): void
    {
        if ($this->type === $type) {
            return;
        }

        if (!$type->hasOptions() && !$this->options->isEmpty()) {
            throw new \DomainException(
                'Cannot change attribute type while options exist.',
            );
        }

        if (!$type->hasOptions() && $this->variantAxis) {
            throw new \DomainException(
                'Variant axis must use a select or multi-select type.',
            );
        }

        $this->type = $type;
        $this->touch();
    }

    public function addOption(AttributeOption $option): void
    {
        if (!$this->type->hasOptions()) {
            throw new \DomainException(
                'Only select and multi-select attributes can have options.',
            );
        }

        foreach ($this->options as $existingOption) {
            if ($existingOption->code()->equals($option->code())) {
                throw new \DomainException(sprintf(
                    'Attribute option "%s" already exists.',
                    $option->code()->value(),
                ));
            }
        }

        $option->attachTo($this);
        $this->options->add($option);

        $this->touch();
    }

    public function removeOption(AttributeCode $code): void
    {
        foreach ($this->options as $option) {
            if (!$option->code()->equals($code)) {
                continue;
            }

            $this->options->removeElement($option);
            $this->touch();

            return;
        }
    }

    public function markAsRequired(): void
    {
        if ($this->required) {
            return;
        }

        $this->required = true;
        $this->touch();
    }

    public function markAsOptional(): void
    {
        if (!$this->required) {
            return;
        }

        $this->required = false;
        $this->touch();
    }

    public function markAsFilterable(): void
    {
        if ($this->filterable) {
            return;
        }

        $this->filterable = true;
        $this->touch();
    }

    public function markAsNotFilterable(): void
    {
        if (!$this->filterable) {
            return;
        }

        $this->filterable = false;
        $this->touch();
    }

    public function markAsSearchable(): void
    {
        if ($this->searchable) {
            return;
        }

        $this->searchable = true;
        $this->touch();
    }

    public function markAsNotSearchable(): void
    {
        if (!$this->searchable) {
            return;
        }

        $this->searchable = false;
        $this->touch();
    }

    public function markAsVariantAxis(): void
    {
        if (!$this->type->hasOptions()) {
            throw new \DomainException(
                'Only select and multi-select attributes can be variant axes.',
            );
        }

        if ($this->variantAxis) {
            return;
        }

        $this->variantAxis = true;
        $this->touch();
    }

    public function removeFromVariantAxis(): void
    {
        if (!$this->variantAxis) {
            return;
        }

        $this->variantAxis = false;
        $this->touch();
    }

    public function enable(): void
    {
        if ($this->enabled) {
            return;
        }

        $this->enabled = true;
        $this->touch();
    }

    public function disable(): void
    {
        if (!$this->enabled) {
            return;
        }

        $this->enabled = false;
        $this->touch();
    }

    public function id(): AttributeId
    {
        return $this->id;
    }

    public function code(): AttributeCode
    {
        return $this->code;
    }

    public function name(): AttributeName
    {
        return $this->name;
    }

    public function type(): AttributeType
    {
        return $this->type;
    }

    public function required(): bool
    {
        return $this->required;
    }

    public function filterable(): bool
    {
        return $this->filterable;
    }

    public function searchable(): bool
    {
        return $this->searchable;
    }

    public function variantAxis(): bool
    {
        return $this->variantAxis;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return list<AttributeOption>
     */
    public function options(): array
    {
        return array_values($this->options->toArray());
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}