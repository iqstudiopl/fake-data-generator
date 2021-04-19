<?php

namespace IQStudio\Test\PersonGenerator\Helper;

class CsvHelper
{
    public static function getPossibleValues(string $filename): array
    {
        if (!file_exists($filename)) {
            throw new \DomainException("No dictionary found in {$filename}");
        }

        $names = [];

        if (($handle = fopen($filename, "r")) === false) {
            throw new \RuntimeException("Cannot open file {$filename}");

        }
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (!isset($data[1]) || !is_numeric($data[1])) {
                continue;
            }
            $names[] = $data[0];
        }
        fclose($handle);
        return $names;
    }
}
