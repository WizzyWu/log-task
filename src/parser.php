<?php
require dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use LogParser\Readers\LogReader;

$filename = $argv[1];
if (!$filename) {
    $filename = __DIR__ . DIRECTORY_SEPARATOR . 'webserver.log';
}

try {
    $logReader = new LogReader($filename);
} catch (\Exception $e) {
    echo '\n'.$e->getMessage();
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