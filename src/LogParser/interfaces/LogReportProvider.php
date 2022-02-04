<?php
namespace LogParser\Interfaces;

Interface LogReportProvider {
    public function provideReport (LogStorage $logStorage);
}