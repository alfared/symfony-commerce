<?php

namespace App\Shared\Application\Scaffolding;

final class GeneratorRegistry
{
    /**
     * @param iterable<GeneratorInterface> $generators
     */
    public function __construct(
        private iterable $generators
    ) {
    }

    public function get(string $type): GeneratorInterface
    {
         foreach ($this->generators as $generator) {
            if ($generator->type() === $type) {
                return $generator;
            }
         }

        throw new \InvalidArgumentException(sprintf(
            'Unknown generator type "%s".',
            $type
        ));
    }
}