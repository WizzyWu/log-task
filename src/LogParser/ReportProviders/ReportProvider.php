<?php
namespace LogParser\ReportProviders;

use LogParser\Interfaces;
use LogParser\Interfaces\LogStorage;

Class ReportProvider implements Interfaces\LogReportProvider
{
    public function provideReport(LogStorage $logStorage)
    {
        /* @var $logRecord Interfaces\StatisticsProvider  */
        foreach ($logStorage as $logRecord) {
            echo "\n".$logRecord->getStatistics();
        }
    }
}