<?php

declare(strict_types=1);

namespace IQStudio\PersonGenerator\Generator\Gender;

use IQStudio\PersonGenerator\Enum\Gender;
use IQStudio\PersonGenerator\Generator\RandomInt;

class GenderGenerator implements GenderGeneratorInterface
{
    public function __invoke(): Gender
    {
        return $this->generate();
    }

    public function generate(): Gender
    {
        return
            RandomInt::between(1, 100) < 50
                ? Gender::male()
                : Gender::female();
    }
}
