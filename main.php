<?php

require('vendor/autoload.php');

/**
 * @param SplFileInfo $sourceFile
 * @param $destinationFolder
 * @param $delimiter
 * @param $enclosure
 * @param $escapedBy
 * @param $columnName
 */
function processFile(SplFileInfo $sourceFile, $destinationFolder, $delimiter, $enclosure, $escapedBy, $columnName)
{
    $sourceCsv = new \Keboola\Csv\CsvFile($sourceFile->getPathname(), $delimiter, $enclosure, $escapedBy);
    $destinationCsv = new \Keboola\Csv\CsvFile($destinationFolder . $sourceFile->getFilename(), $delimiter, $enclosure, $escapedBy);
    if ($columnName) {
        $header = $sourceCsv->getHeader();
        $header[] = $columnName;
        $destinationCsv->writeRow($header);
    }

    foreach ($sourceCsv as $index => $row) {
        if ($columnName) {
            $rowNumber = $index;
            // skip header
            if ($index == 0) {
                continue;
            }
        } else {
            $rowNumber = $index + 1;
        }
        $row[] = $rowNumber;
        $destinationCsv->writeRow($row);
    }
}

try {
    $dataDir = getenv('KBC_DATADIR') === false ? '/data/' : getenv('KBC_DATADIR');
    $delimiter = getenv('KBC_PARAMETER_DELIMITER') === false ? ',' : getenv('KBC_PARAMETER_DELIMITER');
    $enclosure = getenv('KBC_PARAMETER_ENCLOSURE') === false ? '"' : getenv('KBC_PARAMETER_ENCLOSURE');
    $escapedBy = getenv('KBC_PARAMETER_ESCAPED_BY') === false ? '' : getenv('KBC_PARAMETER_ESCAPED_BY');
    $columnName = getenv('KBC_PARAMETER_COLUMN_NAME') === false ? '' : getenv('KBC_PARAMETER_COLUMN_NAME');
    $files = new FilesystemIterator($dataDir . 'in/tables/', FilesystemIterator::SKIP_DOTS);
    $destination = $dataDir . 'out/tables/';
    /** @var FilesystemIterator $file */
    foreach ($files as $file) {
        if ($file->getExtension() == 'manifest') {
            rename($file->getPathname(), $destination . $file->getFilename());
        } else {
            if (is_dir($file->getPathname())) {
                // sliced file
                $slicedFiles = new FilesystemIterator($file->getPathname(), FilesystemIterator::SKIP_DOTS);
                $slicedDestination = $destination . $file->getFilename() . '/';
                if (!file_exists($slicedDestination)) {
                    mkdir($slicedDestination);
                }
                foreach ($slicedFiles as $slicedFile) {
                    processFile($slicedFile, $slicedDestination, $delimiter, $enclosure, $escapedBy, $columnName);
                }
            } else {
                processFile($file, $destination, $delimiter, $enclosure, $escapedBy, $columnName);
            }

        }
    }
} catch (\Keboola\Csv\InvalidArgumentException $e) {
    echo $e->getMessage();
    exit(1);
} catch (\Exception $e) {
    echo $e->getMessage();
    exit(2);
}
