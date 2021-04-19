<?php

namespace IQStudio\PersonGenerator\Generator;

class RandomInt
{
    public static function between(int $min, int $max): int
    {
        return random_int($min, $max);
    }

    public static function max(int $max): int
    {
        return self::between(0, $max);
    }
}
