<?php

declare(strict_types=1);

namespace IQStudio\PersonGenerator\Chooser;

use IQStudio\PersonGenerator\Chooser\ChooserInterface;
use IQStudio\PersonGenerator\Generator\RandomInt;

class CsvStatisticalChooser implements ChooserInterface
{

    private int $length = 0;

    private bool $initialized = false;

    private string $filename;

    private array $names = [];

    /** @var int[] */
    private array $probabilityList = [];

    /** @var int[] */
    private array $numOfRepeats = [];

    private int $probabilityTotal = 0;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getElement(): string
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        $rand = RandomInt::max($this->probabilityTotal - 1);

        foreach ($this->probabilityList as $key => $limit) {
            if ($limit < $rand) {
                continue;
            }
            return $this->names[$key];
        }

        throw new \OutOfBoundsException();
    }

    private function initialize(): void
    {
        $row = 0;
        if (($handle = fopen($this->filename, "r")) === false) {
            throw new \RuntimeException();
        }

        $offset = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (!is_numeric($data[1])) {
                continue;
            }

            $this->names[] = $data[0];
            $this->probabilityList[] = $offset + $data[1];
            $this->numOfRepeats[] = $data[1];
            $offset += $data[1];

            ++$row;
        }
        $this->probabilityTotal = $offset;
        fclose($handle);

        $this->length = $row;

        $this->initialized = true;
    }

    /**
     * @param string $name
     * @return float
     * @deprecated To be removed
     */
    public function findProbabilityFor(string $name): float
    {
        $key = array_search($name, $this->names);
        if ($key === false) {
            return 0.0;
        }
        return $this->numOfRepeats[$key] / $this->probabilityTotal;
    }
}
