<?php
namespace LogParser\Test;
require dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR. "autoload.php";

use PHPUnit\Framework\TestCase;
use LogParser\Model\Entities\LogRecord;

class LogRecordTest extends TestCase
{
    public function testConstructor () {
        $LogRecord = new LogRecord('/help_page/1 126.318.035.038');
        $this->assertEquals(
            '/help_page/1',
            $LogRecord->getId(),
            "Incorrect identifier definition"
        );
        $this->assertEquals(
            1,
            $LogRecord->getOccurrences(),
            "Incorrect occurrences definition"
        );
        $this->assertEquals(
            1,
            $LogRecord->getUniqueOccurrences(),
            "Incorrect unique occurrences definition"
        );
    }

    public function testConstructorException () {
        $this->expectException('InvalidArgumentException');
        new LogRecord('/help_page/1');
        $this->expectExceptionMessage('Expected Exception Message');
    }

    public function testAddAdditionalRecord () {
        $LogRecord = new LogRecord('/help_page/1 126.318.035.038');
        $LogRecord->addAdditionalRecord('/help_page/1 126.318.035.038');
        $LogRecord->addAdditionalRecord('/help_page/1 126.318.035.039');
        $this->assertEquals(
            3,
            $LogRecord->getOccurrences(),
            "Incorrect occurrences calculation"
        );
        $this->assertEquals(
            2,
            $LogRecord->getUniqueOccurrences(),
            "Incorrect unique occurrences calculation"
        );
    }

    public function testGetStatistics () {
        $LogRecord = new LogRecord('/help_page/1 126.318.035.038');
        $LogRecord->addAdditionalRecord('/help_page/1 126.318.035.038');
        $LogRecord->addAdditionalRecord('/help_page/1 126.318.035.039');
        $this->assertEquals(
            '/help_page/1 3 visits 2 unique',
            $LogRecord->getStatistics(),
            "Incorrect statistics generation"
        );
    }

    public function testGetIdFromLogLine () {
        $LogLineId = LogRecord::getIdFromLogLine('/help_page/1 126.318.035.038');
        $this->assertEquals(
            '/help_page/1',
            $LogLineId,
            'Incorrect work of static function LogRecord::getIdFromLogLine($logLine)'
        );
    }

}