<?php
namespace LogParser\Interfaces;

Interface LogStorage extends \IteratorAggregate{
    public function addLogRecord(LogRecord $logRecord);
    public function getLogRecordById($logRecordId);
    public function checkIfIdExists($logRecordId);
    public function sortItemsByOccurrences();
    public function sortItemsByUniqueOccurrences();
}