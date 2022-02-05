<?php
namespace LogParser\Interfaces;

Interface LogRecord {
    public function getId();
    public function getOccurrences();
    public function getUniqueOccurrences();
    public function addAdditionalRecord ($logLine);
    public static function getIdFromLogLine ($logLine);
}