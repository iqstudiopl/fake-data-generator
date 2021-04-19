<?php

declare(strict_types=1);

namespace IQStudio\PersonGenerator\Generator\Identifier;

use IQStudio\PersonGenerator\Enum\Gender;
use IQStudio\PersonGenerator\Generator\RandomInt;

class PeselGenerator implements PeselGeneratorInterface
{
    public function generate(Gender $gender): string
    {
        $date = $this->randomDate();
        $rand = RandomInt::max(100000) % 1000;

        $genderNum = RandomInt::max(4) * 2 + ($gender->isFemale() ? 0 : 1);

        $monthDigits = (int)$date->format('n');

        $century = (int)substr((string)$date->format('Y'), 0, 2);
        switch ($century) {
            case 18:
                $monthDigits += 80;
                break;
            case 20:
                $monthDigits += 20;
                break;
            case 21:
                $monthDigits += 40;
                break;
            case 22:
                $monthDigits += 60;
                break;
        }

        $number = sprintf(
            '%s%02d%s%03d%d',
            $date->format('y'),
            $monthDigits,
            $date->format('d'),
            $rand,
            $genderNum
        );

        $crc = (string)$this->calculateCrc($number);
        $number .= $crc;
        return $number;
    }

    private function calculateCrc(string $number)
    {
        $arrWagi = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3);
        $intSum = 0;

        //mnożymy każdy ze znaków przez wagę i sumujemy wszystko
        for ($i = 0; $i < 10; $i++) {
            $intSum += $arrWagi[$i] * $number[$i];
        }

        //obliczamy sumę kontrolną i porównujemy ją z ostatnią cyfrą.
        $int = 10 - $intSum % 10;
        return ($int == 10) ? 0 : $int;
    }

    private function randomDate(): \DateTimeInterface
    {
        $year = RandomInt::between(
            (int)date('Y')-100,
            (int)date('Y')-1
        );
        $month = RandomInt::between(1, 12);

        $daysInMonth = (int)(\DateTime::createFromFormat('Y-m-01', $year . '-' . $month . '-01'))->format('t');
        $day = RandomInt::between(1, $daysInMonth);

        return \DateTime::createFromFormat('Y-n-j', "$year-$month-$day");
    }
}
