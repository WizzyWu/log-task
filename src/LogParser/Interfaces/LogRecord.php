<?php
namespace LogParser\Interfaces;

Interface LogRecord {
    public function addAdditionalRecord ($logLine);
    public static function getIdFromLogLine ($logLine);
}