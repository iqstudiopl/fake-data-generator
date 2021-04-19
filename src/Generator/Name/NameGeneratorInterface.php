<?php

namespace IQStudio\PersonGenerator\Generator\Name;

use IQStudio\PersonGenerator\Enum\Gender;

interface NameGeneratorInterface
{
    public function generate(Gender $gender): string;
}