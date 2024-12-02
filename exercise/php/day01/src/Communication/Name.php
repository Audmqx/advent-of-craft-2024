<?php

declare(strict_types=1);

namespace Communication;

final class Name
{   
    private string $name {
        set (string $value) {
            if (!$this->isAlphaString($value)) {
                throw new InvalidArgumentException('Invalid name');
            }
            $this->name = $value;
         }
    }

    public function __construct(string $name){
        $this->name = $name;
    }

    private function isAlphaString($name): bool {
        return is_string($name) && ctype_alpha($name);
    }

    public function asString(): string
    {
        return $this->name;
    }
}