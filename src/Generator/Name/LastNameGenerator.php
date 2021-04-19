<?php

declare(strict_types=1);

namespace IQStudio\PersonGenerator\Generator\Name;

use IQStudio\PersonGenerator\Chooser\CsvRandomChooser;
use IQStudio\PersonGenerator\Chooser\CsvStatisticalChooser;
use IQStudio\PersonGenerator\Enum\DataSourceEnum;
use IQStudio\PersonGenerator\Enum\Gender;

class LastNameGenerator implements NameGeneratorInterface
{
    /** @var CsvRandomChooser[] */
    private $generators = [];

    public function __invoke(Gender $gender): string
    {
        return $this->generate($gender);
    }

    public function generate(Gender $gender): string
    {
        if (!isset($this->generators[(string)$gender])) {
            $filename = $gender->isMale()
                ? DataSourceEnum::PL_LAST_NAME_MALES
                : DataSourceEnum::PL_LAST_NAME_FEMALES;
            $this->generators[(string)$gender] = new CsvStatisticalChooser($filename);
        }

        return $this->generators[(string)$gender]->getElement();
    }

}
