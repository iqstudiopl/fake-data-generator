<?php

namespace IQStudio\Test\PersonGenerator\Generator\Gender;

use IQStudio\PersonGenerator\Enum\Gender;
use IQStudio\PersonGenerator\Generator\Gender\GenderGenerator;
use PHPUnit\Framework\TestCase;

class GenderGeneratorTest extends TestCase
{
    private const TEST_ITERATIONS = 500;

    public function testGenerate()
    {
        $generator = new GenderGenerator();

        $generatedValues = [
            Gender::MALE => 0,
            Gender::FEMALE => 0,
        ];
        for($i=0; $i < self::TEST_ITERATIONS; ++$i) {
            $gender = $generator->generate();
            self::assertInstanceOf(Gender::class, $gender);

            ++$generatedValues[$gender->getValue()];
        }

        self::assertGreaterThan(
            0.3 * self::TEST_ITERATIONS,
            $generatedValues[Gender::MALE],
            'Expecting at least 30% of males'
        );
        self::assertGreaterThan(
            0.3 * self::TEST_ITERATIONS,
            $generatedValues[Gender::FEMALE],
            'Expecting at least 30% of females'
        );
    }
}
