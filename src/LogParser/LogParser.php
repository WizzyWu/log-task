<?php
namespace LogParser;

use \LogParser\Interfaces;
use \LogParser\Model\Entities\LogRecord;

Class LogParser {
    private $reader;
    private $logStorage;
    private $errorsList = [];

    public function __construct(
        Interfaces\LogReader $reader,
        Interfaces\LogStorage $logStorage) {
        $this->reader = $reader;
        $this->logStorage = $logStorage;

        foreach ($reader as $logLine) {
            $this->parseLogLine($logLine);
        }
    }

    public function parseLogLine ($logLine) {
        $logLineId = LogRecord::getIdFromLogLine($logLine);
        // if a record with the same ID already exists in the storage
        try {
            if ($this->logStorage->checkIfIdExists($logLineId)) {
                $logRecord = $this->logStorage->getLogRecordById($logLineId);
                $logRecord->addAdditionalRecord($logLine);
            } else {
                // otherwise, create a new object
                $logRecord = new LogRecord($logLine);
                $this->logStorage->addLogRecord($logRecord);
            }
        } catch (\Exception $e) {
            $this->errorsList[] = $e->getMessage();
        }
    }

    public function provideOccurrencesSortedReport (Interfaces\LogReportProvider $reportProvider) {
        $this->logStorage->sortItemsByOccurrences();
        return $reportProvider->provideReport($this->logStorage);
    }

    public function provideUniqueOccurrencesSortedReport (Interfaces\LogReportProvider $reportProvider) {
        $this->logStorage->sortItemsByUniqueOccurrences();
        return $reportProvider->provideReport($this->logStorage);
    }

    public function showErrorsLis () {
        if (count($this->errorsList) > 0) {
            echo '|||| Errors list:' . implode(' | ', $this->errorsList);
        }
    }
}