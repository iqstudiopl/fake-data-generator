<?php

declare(strict_types=1);

namespace IQStudio\PersonGenerator\Chooser;

use IQStudio\PersonGenerator\Chooser\ChooserInterface;

class CsvRandomChooser implements ChooserInterface
{
    private array $elements = [];

    private int $length = 0;

    private bool $initialized = false;

    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getElement(): string
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        return $this->elements[random_int(0, $this->length - 1)];
    }

    private function initialize(): void
    {
        $row = 0;
        if (($handle = fopen($this->filename, "r")) === false) {
            throw new \RuntimeException();
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (!is_numeric($data[1])) {
                continue;
            }

            $this->elements[] = $data[0];

            ++$row;
        }
        fclose($handle);
        $this->length = $row;

        $this->initialized = true;
    }
}
