<?php

namespace App\Catalog\Category\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use App\Catalog\Category\Infrastructure\Doctrine\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'catalog_category')]
class Category
{
}