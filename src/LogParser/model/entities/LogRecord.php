<?php
namespace LogParser\Model\Entities;

use LogParser\Interfaces;

/**
 * A class that works with each line of the log
 */
Class LogRecord implements Interfaces\LogRecord, Interfaces\StatisticsProvider {
    protected $id;
    protected $ipList = [];

    public function __construct ($logLine) {
        $parseResult = self::parseStringLogLine($logLine);
        $this->id = $parseResult['id'];
        $this->addIpOccurrence($parseResult['ip']);
    }

    public function getId () {
        return $this->id;
    }

    /**
     * method parses the log line into 2 parts
     * [
     *  'id' => ...
     *  'ip' => ...
     * ]
     * @param $logLine
     * @return array
     */
    static function parseStringLogLine ($logLine) {
        $pattern = '/(.+)\s(.+)/';
        // check if it differs from the format with which we can work
        if (!preg_match($pattern, $logLine, $matches)) {
            throw new \InvalidArgumentException('Log line mismatch');
        }
        return [
            'id' => $matches[1],
            'ip' => $matches[2],
        ];
    }

    /**
     * method adds a visit
     * @param $ip
     * @return void
     */
    protected function addIpOccurrence ($ip) {
        if (!isset($this->ipList[$ip])) $this->ipList[$ip] = 0;
        $this->ipList[$ip]++;
    }

    /**
     * method returns number of all visits of link
     * @return float|int
     */
    public function getOccurrences () {
        return array_sum(array_values($this->ipList));
    }

    /**
     * method returns number of unique visitors of link
     * @return int
     */
    public function getUniqueOccurrences () {
        return count($this->ipList);
    }

    /**
     * method gives statistics about link as a string
     * @return string
     */
    public function getStatistics () {
        return implode(" ", [
            $this->getId(),
            $this->getOccurrences(),
            "visits",
            $this->getUniqueOccurrences(),
            "unique"
        ]);
    }

    public function addAdditionalRecord ($logLine) {
        $parseResult = self::parseStringLogLine($logLine);
        $this->addIpOccurrence($parseResult['id']);
    }

    public static function getIdFromLogLine ($logLine) {
        $parseResult = self::parseStringLogLine($logLine);
        return $parseResult['id'];
    }
}