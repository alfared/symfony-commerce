<?php

namespace App\{{ Context }}\{{ Entity }}\Domain\Factory;

use App\{{ Context }}\{{ Entity }}\Domain\Model\{{ Entity }};

final readonly class {{ Entity }}Factory
{
    public function createWithData(
        string $code,
        string $name,
        string $slug,
        ?string $description = null,
        bool $enabled = true,
    ): {{ Entity }} {
        ${{ entity }} = new {{ Entity }}();

        ${{ entity }}->setCode($code);
        ${{ entity }}->setName($name);
        ${{ entity }}->setSlug($slug);
        ${{ entity }}->setDescription($description);
        ${{ entity }}->setEnabled($enabled);

        return ${{ entity }};
    }
}