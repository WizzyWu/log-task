<?php
require dirname(__FILE__, 1) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use LogParser\Readers\LogReader;

$filename = $argv[1];

if (empty($filename)) {
    echo "\nYou must specify a file for the data parse. Exemple: >php parser.php 'logfile.log";
}

try {
    $logReader = new LogReader($filename);
} catch (\Exception $e) {
    echo "\nAn error occurred while opening the file $filename";
    die;
}
$logStorage = new LogParser\Model\LogStorage();
$logParser = new LogParser\LogParser($logReader, $logStorage);
echo "\n\nOccurrencesSortedReport:";
$logParser->provideOccurrencesSortedReport(new LogParser\ReportProviders\ReportProvider());
echo "\n\nUniqueOccurrencesSortedReport:";
$logParser->provideUniqueOccurrencesSortedReport(new LogParser\ReportProviders\ReportProvider());
echo "\n";
$logParser->showErrorsLis();
echo "\n";