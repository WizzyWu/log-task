<?php
namespace LogParser\Readers;

use LogParser\Interfaces;
use LogParser\Model\LogFileIterator;

Class LogReader implements Interfaces\LogReader {
    protected $file;

    public function __construct($filename)
    {
        try {
            $this->file = new \SplFileObject($filename);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function __destruct()
    {
        $this->file = null;
    }

    public function getIterator()
    {
        return new LogFileIterator($this->file);
    }


}