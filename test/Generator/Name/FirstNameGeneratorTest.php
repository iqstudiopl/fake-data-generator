<?php

namespace IQStudio\Test\PersonGenerator\Generator\Name;

use IQStudio\PersonGenerator\Enum\Gender;
use IQStudio\PersonGenerator\Generator\Name\FirstNameGenerator;
use IQStudio\Test\PersonGenerator\Helper\CsvHelper;
use PHPUnit\Framework\TestCase;

class FirstNameGeneratorTest extends TestCase
{
    private const FILE_DICT_MALES = __DIR__ . '/../../../resource/dict/pl/first-name-males.csv';
    private const FILE_DICT_FEMALES = __DIR__ . '/../../../resource/dict/pl/first-name-females.csv';
    private const TEST_ITERATIONS = 100;

    public function testFemaleNames()
    {
        $possibleNames = CsvHelper::getPossibleValues(self::FILE_DICT_FEMALES);
        $gender = Gender::female();

        $generator = new FirstNameGenerator();

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

        $generator = new FirstNameGenerator();

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
