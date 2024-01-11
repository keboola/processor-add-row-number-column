<?php
namespace Keboola\Processor\AddRowNumberColumn;

use Keboola\Csv\CsvReader;
use Keboola\Csv\CsvWriter;

/**
 * @param \SplFileInfo $sourceFile
 * @param $destinationFolder
 * @param $delimiter
 * @param $enclosure
 */
function processFile(\SplFileInfo $sourceFile, $destinationFolder, $delimiter, $enclosure)
{
    $sourceCsv = new CsvReader($sourceFile->getPathname(), $delimiter, $enclosure);
    $destinationCsv = new CsvWriter($destinationFolder . $sourceFile->getFilename(), $delimiter, $enclosure);
    foreach ($sourceCsv as $index => $row) {
        $rowNumber = $index + 1;
        $row[] = $rowNumber;
        $destinationCsv->writeRow($row);
    }
}
