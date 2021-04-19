<?php

namespace IQStudio\Test\PersonGenerator\Generator\Name;

use IQStudio\PersonGenerator\Enum\Gender;
use IQStudio\PersonGenerator\Generator\Name\LastNameGenerator;
use IQStudio\Test\PersonGenerator\Helper\CsvHelper;
use PHPUnit\Framework\TestCase;

class LastNameGeneratorTest extends TestCase
{
    private const FILE_DICT_MALES = __DIR__ . '/../../../resource/dict/pl/last-name-males.csv';
    private const FILE_DICT_FEMALES = __DIR__ . '/../../../resource/dict/pl/last-name-females.csv';
    private const TEST_ITERATIONS = 100;

    public function testFemaleNames()
    {
        $possibleNames = CsvHelper::getPossibleValues(self::FILE_DICT_FEMALES);
        $gender = Gender::female();

        $generator = new LastNameGenerator();

        $generatedNames = [];
        for ($i = 0; $i < self::TEST_ITERATIONS; ++$i) {
            $name = $generator->generate($gender);
            self::assertContains($name, $possibleNames);

            if (!isset($generatedNames[$name])) {
                $generatedNames[$name] = 0;
            }
            $generatedNames[$name]++;
        }

        self::assertGreaterThan(1, count($generatedNames), 'More than one unique name should be generated');
    }

    public function testMaleNames()
    {
        $possibleNames = CsvHelper::getPossibleValues(self::FILE_DICT_MALES);
        $gender = Gender::male();

        $generator = new LastNameGenerator();

        $generatedNames = [];
        for ($i = 0; $i < self::TEST_ITERATIONS; ++$i) {
            $name = $generator->generate($gender);
            self::assertContains($name, $possibleNames);

            if (!isset($generatedNames[$name])) {
                $generatedNames[$name] = 0;
            }
            $generatedNames[$name]++;
        }

        self::assertGreaterThan(1, count($generatedNames), 'More than one unique name should be generated');
    }
}
