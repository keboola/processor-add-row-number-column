<?php
namespace Keboola\Processor\AddRowNumberColumn;

use Keboola\Csv\CsvFile;

/**
 * @param \SplFileInfo $sourceFile
 * @param $destinationFolder
 * @param $delimiter
 * @param $enclosure
 */
function processFile(\SplFileInfo $sourceFile, $destinationFolder, $delimiter, $enclosure)
{
    $sourceCsv = new CsvFile($sourceFile->getPathname(), $delimiter, $enclosure);
    $destinationCsv = new CsvFile($destinationFolder . $sourceFile->getFilename(), $delimiter, $enclosure);
    foreach ($sourceCsv as $index => $row) {
        $rowNumber = $index + 1;
        $row[] = $rowNumber;
        $destinationCsv->writeRow($row);
    }
}
