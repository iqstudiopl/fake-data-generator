<?php

namespace IQStudio\PersonGenerator\Generator\Gender;

use IQStudio\PersonGenerator\Enum\Gender;

interface GenderGeneratorInterface
{
    public function generate(): Gender;
}
