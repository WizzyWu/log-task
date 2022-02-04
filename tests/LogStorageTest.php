<?php
namespace LogParser\Test;
require dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR. "autoload.php";

use PHPUnit\Framework\TestCase;
use LogParser\Model\LogStorage;

class LogStorageTest extends TestCase
{

    public function setUp()
    {
        $this->LogStorage = new LogStorage();
    }

    public function tearDown()
    {
        unset($this->LogStorage);
    }

    public function testAddDifferentLogRecords () {
        $logRecord1 = $this->getMockBuilder('LogParser\Model\Entities\LogRecord')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();
        $logRecord1->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));

        $logRecord2 = $this->getMockBuilder('LogParser\Model\Entities\LogRecord')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();
        $logRecord2->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('2'));

        $this->LogStorage->addLogRecord($logRecord1);
        $this->LogStorage->addLogRecord($logRecord2);

        $this->assertEquals(
            2,
            count($this->LogStorage->getItems()),
            "Incorrect different items adding"
        );
    }
    public function testSameLogRecords () {
        $logRecord1 = $this->getMockBuilder('LogParser\Model\Entities\LogRecord')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();
        $logRecord1->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));

        $logRecord2 = $this->getMockBuilder('LogParser\Model\Entities\LogRecord')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();
        $logRecord2->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));

        $this->expectException('Exception');
        $this->LogStorage->addLogRecord($logRecord1);
        $this->LogStorage->addLogRecord($logRecord2);
        $this->expectExceptionMessage('Expected Exception Message');
    }

    public function testCheckIfIdExists () {
        $logRecord1 = $this->getMockBuilder('LogParser\Model\Entities\LogRecord')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();
        $logRecord1->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));
        $this->LogStorage->addLogRecord($logRecord1);

        $this->assertEquals(
            true,
            $this->LogStorage->checkIfIdExists('1'),
            "Incorrect work of method checkIfIdExists()"
        );
        $this->assertEquals(
            false,
            $this->LogStorage->checkIfIdExists('2'),
            "Incorrect work of method checkIfIdExists()"
        );
    }

    public function testGetLogRecordById () {
        $logRecord1 = $this->getMockBuilder('LogParser\Model\Entities\LogRecord')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();
        $logRecord1->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));
        $this->LogStorage->addLogRecord($logRecord1);

        $this->assertEquals(
            $logRecord1,
            $this->LogStorage->getLogRecordById('1'),
            "Incorrect work of method getLogRecordById"
        );

        $this->expectException('Exception');
        $this->LogStorage->getLogRecordById('2');
    }


}