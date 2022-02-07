<?php
namespace LogParser\IntegrationTest;
require dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR. "autoload.php";

use PHPUnit\Framework\TestCase;

use LogParser\Model;
use LogParser;
use LogParser\ReportProviders;

class ApplicationTest extends TestCase
{
    public function testRunWithoutFilename () {
        $filename = null;
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('SplFileObject::__construct(): Filename cannot be empty');
        $logReader = new LogParser\Readers\LogReader($filename);
        $logStorage = new LogParser\Model\LogStorage();
        $logParser = new LogParser\LogParser($logReader, $logStorage);
        $result = $logParser->provideOccurrencesSortedReport(new LogParser\ReportProviders\ReportAsStringProvider());
    }

    public function testRunWithWrongFilename () {
        $filename = 'wrongname.log';
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('SplFileObject::__construct(wrongname.log): failed to open stream: No such file or directory');
        $logReader = new LogParser\Readers\LogReader($filename);
        $logStorage = new LogParser\Model\LogStorage();
        $logParser = new LogParser\LogParser($logReader, $logStorage);
        $result = $logParser->provideOccurrencesSortedReport(new LogParser\ReportProviders\ReportAsStringProvider());
    }

    public function testRunOccurrencesSorted () {
        $filename = 'webserver.log';
        $logReader = new LogParser\Readers\LogReader($filename);
        $logStorage = new LogParser\Model\LogStorage();
        $logParser = new LogParser\LogParser($logReader, $logStorage);
        $result = $logParser->provideOccurrencesSortedReport(new LogParser\ReportProviders\ReportAsStringProvider());
        $this->assertEquals(
            '/about/2 90 visits 22 unique, /contact 89 visits 23 unique, /index 82 visits 23 unique, /about 81 visits 21 unique, /help_page/1 80 visits 23 unique, /home 78 visits 23 unique',
            $result,
            "Application incorrectly provides occurrences sorted report"
        );
    }

    public function testRunUniqueOccurrencesSorted () {
        $filename = 'webserver.log';
        $logReader = new LogParser\Readers\LogReader($filename);
        $logStorage = new LogParser\Model\LogStorage();
        $logParser = new LogParser\LogParser($logReader, $logStorage);
        $result = $logParser->provideUniqueOccurrencesSortedReport(new LogParser\ReportProviders\ReportAsStringProvider());
        $this->assertEquals(
            '/help_page/1 80 visits 23 unique, /contact 89 visits 23 unique, /home 78 visits 23 unique, /index 82 visits 23 unique, /about/2 90 visits 22 unique, /about 81 visits 21 unique',
            $result,
            "Application incorrectly provides unique occurrences sorted report"
        );
    }
}