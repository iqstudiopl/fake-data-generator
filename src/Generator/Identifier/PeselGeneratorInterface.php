<?php

namespace IQStudio\PersonGenerator\Generator\Identifier;

use IQStudio\PersonGenerator\Enum\Gender;

interface PeselGeneratorInterface
{
    public function generate(Gender $gender): string;
}