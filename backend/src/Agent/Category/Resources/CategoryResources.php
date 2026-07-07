<?php

namespace App\Agent\Category\Resources;

use App\Agent\Shared\Base\AbstractResource;
use App\Agent\Shared\Contract\ResourceInterface;
use App\Agent\Shared\Mapper\CategoryMapper;
use App\Catalog\Category\Domain\Model\Category;
use App\Catalog\Category\Domain\Repository\CategoryRepositoryInterface;
use Mcp\Capability\Attribute\McpResource;

final readonly class CategoryResources extends AbstractResource implements ResourceInterface
{
     public function __construct(
        private CategoryRepositoryInterface $categories,
        private CategoryMapper $mapper,
    ) {
    }

    #[McpResource(
        uri: 'category://list',
        name: 'category_list',
        description: 'List enabled catalog categories'
    )]
    public function listCategories(): array 
    {
        return $this->collection(
            $this->mapper->manyToArray($this->categories->findAllEnabled())
        );
    }
}