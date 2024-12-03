<?php

declare(strict_types=1);

namespace Games;

use ReflectionClass;
use Exception;

class Mapping {
    public static function add(int $key, string $value): void {
        $reflection = new ReflectionClass(FizzBuzz::class);
        $property = $reflection->getProperty('mapping');
        $property->setAccessible(true);

        $mapping = $property->getValue();

        if(isset($mapping[$key])){
            throw new Exception('dupplikeys');
        }

        $mapping[$key] = $value;
        $property->setValue(null, $mapping);
    }
}
