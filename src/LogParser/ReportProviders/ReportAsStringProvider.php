<?php
namespace LogParser\ReportProviders;

use LogParser\Interfaces;
use LogParser\Interfaces\LogStorage;

Class ReportAsStringProvider implements Interfaces\LogReportProvider
{
    public function provideReport(LogStorage $logStorage)
    {
        $resultStringArray = [];
        /* @var $logRecord Interfaces\StatisticsProvider  */
        foreach ($logStorage as $logRecord) {
            $resultStringArray.push($logRecord->getStatistics());
        }
        return implode(', ', $resultStringArray);
    }
}