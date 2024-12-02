<?php

declare(strict_types=1);

namespace Communication;

final class Location
{
    private string $location {
        set (string $value) {
            if (empty($value) || !is_string($value)) {
                throw new InvalidArgumentException('Invalid location');
            }
            $this->location = $value;
        }
    }

    public function __construct(string $location){
        $this->location = $location;
    }

    public function asString(): string
    {
        return $this->location;
    }
}