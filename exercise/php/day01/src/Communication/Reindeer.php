<?php

declare(strict_types=1);

namespace Communication;

final class Reindeer
{
    private $name;
    private $location;

    public function __construct(Name $name, Location $location)
    {
        $this->name = $name;
        $this->location = $location;
    }

    public function name(): string
    {
        return $this->name->asString();
    }

    public function location(): string
    {
        return $this->location->asString();
    }
}
