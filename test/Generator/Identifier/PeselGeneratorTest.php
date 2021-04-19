<?php

namespace IQStudio\Test\PersonGenerator\Generator\Identifier;

use IQStudio\PersonGenerator\Enum\Gender;
use IQStudio\PersonGenerator\Generator\Identifier\PeselGenerator;
use IQStudio\PersonGenerator\Validator\PeselValidator;
use PHPUnit\Framework\TestCase;

class PeselGeneratorTest extends TestCase
{
    private const TEST_ITERATIONS = 100;

    public function testGenerate()
    {
        $generator = new PeselGenerator();
        $validator = new PeselValidator();

        for ($i = 0; $i < self::TEST_ITERATIONS; ++$i) {
            $gender = random_int(0, 100) < 50 ? Gender::male() : Gender::female();

            $pesel = $generator->generate($gender);

            self::assertTrue($validator->isValid($pesel));
            self::assertEquals($gender->getValue(), $validator->getDetails($pesel)['personSex']);
        }
    }
}
