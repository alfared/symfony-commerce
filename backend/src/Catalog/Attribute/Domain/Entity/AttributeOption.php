<?php

declare(strict_types=1);

namespace App\Catalog\Attribute\Domain\Entity;

use App\Catalog\Attribute\Domain\Model\Attribute;
use App\Catalog\Attribute\Domain\ValueObject\AttributeCode;
use App\Catalog\Attribute\Domain\ValueObject\AttributeName;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(
    name: 'catalog_attribute_options',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'uniq_attribute_option_code',
            columns: ['attribute_id', 'code'],
        ),
    ],
)]
final class AttributeOption
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\ManyToOne(
        targetEntity: Attribute::class,
        inversedBy: 'options',
    )]
    #[ORM\JoinColumn(
        name: 'attribute_id',
        referencedColumnName: 'id',
        nullable: false,
        onDelete: 'CASCADE',
    )]
    private Attribute $attribute;

    #[ORM\Column(type: 'attribute_code', length: 64)]
    private AttributeCode $code;

    #[ORM\Column(type: 'attribute_name', length: 255)]
    private AttributeName $name;

    #[ORM\Column(type: 'integer')]
    private int $sortOrder;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled;

    private function __construct(
        string $id,
        AttributeCode $code,
        AttributeName $name,
        int $sortOrder,
        bool $enabled,
    ) {
        if ($sortOrder < 0) {
            throw new \InvalidArgumentException(
                'Sort order cannot be negative.',
            );
        }

        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->sortOrder = $sortOrder;
        $this->enabled = $enabled;
    }

    public static function create(
        AttributeCode $code,
        AttributeName $name,
        int $sortOrder = 0,
    ): self {
        return new self(
            id: (string) Uuid::v7(),
            code: $code,
            name: $name,
            sortOrder: $sortOrder,
            enabled: true,
        );
    }

    public function attachTo(Attribute $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function rename(AttributeName $name): void
    {
        if ($this->name->equals($name)) {
            return;
        }

        $this->name = $name;
    }

    public function changeSortOrder(int $sortOrder): void
    {
        if ($sortOrder < 0) {
            throw new \InvalidArgumentException(
                'Sort order cannot be negative.',
            );
        }

        $this->sortOrder = $sortOrder;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    public function id(): string
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

    public function sortOrder(): int
    {
        return $this->sortOrder;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }
}