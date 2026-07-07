<?php

namespace App\{{ Context }}\{{ Entity }}\Application;

use App\{{ Context }}\{{ Entity }}\Domain\Factory\{{ Entity }}Factory;
use App\{{ Context }}\{{ Entity }}\Domain\Model\{{ Entity }};
use App\{{ Context }}\{{ Entity }}\Domain\Repository\{{ Entity }}RepositoryInterface;

final readonly class Create{{ Entity }}Handler
{
    public function __construct(
        private {{ Entity }}Factory $factory,
        private {{ Entity }}RepositoryInterface $repository,
    ) {
    }

    public function __invoke(Create{{ Entity }}Command $command): {{ Entity }}
    {
        ${{ entity }} = $this->factory->createWithData(
            code: $command->code,
            name: $command->name,
            slug: $command->slug,
            description: $command->description,
            enabled: $command->enabled,
        );

        $this->repository->save(${{ entity }});

        return ${{ entity }};
    }
}