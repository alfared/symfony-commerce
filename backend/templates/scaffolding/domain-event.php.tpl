<?php

namespace {{ Namespace }};

final readonly class {{ ClassName }}
{
    public function __construct(
        public string $aggregateId,
        public \DateTimeImmutable $occurredAt = new \DateTimeImmutable(),
    ) {
    }
}