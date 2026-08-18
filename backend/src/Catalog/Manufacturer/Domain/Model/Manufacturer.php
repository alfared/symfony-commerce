<?php

declare(strict_types=1);

namespace App\Catalog\Manufacturer\Domain\Model;

use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerCode;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerId;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerName;
use App\Catalog\Manufacturer\Domain\ValueObject\ManufacturerSlug;
use App\Catalog\Manufacturer\Infrastructure\Doctrine\ManufacturerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManufacturerRepository::class)]
#[ORM\Table(
    name: 'catalog_manufacturers',
    uniqueConstraints:[
         new ORM\UniqueConstraint(
            name: 'uniq_catalog_manufacturer_code',
            columns: ['code'],
        ),
        new ORM\UniqueConstraint(
            name: 'uniq_catalog_manufacturer_slug',
            columns: ['slug'],
        ),  
    ],
)]

final class Manufacturer
{
    #[ORM\Id]
    #[ORM\Column(type: 'manufacturer_id', length: 36)]
    private ManufacturerId $id;

    #[ORM\Column(type: 'manufacturer_code', length: 64, unique: true)]
    private ManufacturerCode $code;

    #[ORM\Column(type: 'manufacturer_name', length: 255)]
    private ManufacturerName $name;

    #[ORM\Column(type: 'manufacturer_slug', length: 255, unique: true)]
    private ManufacturerSlug $slug;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    private function __construct(
        ManufacturerId $id,
        ManufacturerCode $code,
        ManufacturerName $name,
        ManufacturerSlug $slug,
    ) {
        $now = new \DateTimeImmutable();

        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->slug = $slug;
        $this->enabled = true;
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public static function create(
        ManufacturerCode $code,
        ManufacturerName $name,
        ManufacturerSlug $slug,
    ): self {
        return new self(
            id: ManufacturerId::new(),
            code: $code,
            name: $name,
            slug: $slug,
        );
    }

    public function rename(ManufacturerName $name): void
    {
        if ($this->name->equals($name)) {
            return;
        }

        $this->name = $name;
        $this->touch();
    }

    public function changeSlug(ManufacturerSlug $slug): void
    {
        if ($this->slug->equals($slug)) {
            return;
        }

        $this->slug = $slug;
        $this->touch();
    }

    public function update(
        ManufacturerName $name,
        ManufacturerSlug $slug,
        bool $enabled,
    ):void {
        $this->rename($name);
        $this->changeSlug($slug);

        $enabled
            ? $this->enable()
            : $this->disable();
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

    public function id(): ManufacturerId
    {
        return $this->id;
    }

    public function code(): ManufacturerCode
    {
        return $this->code;
    }

    public function name(): ManufacturerName
    {
        return $this->name;
    }

    public function enabled(): bool
    {
        return $this->enabled;
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

    public function slug(): ManufacturerSlug
    {
        return $this->slug;
    }
}