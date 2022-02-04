<?php
namespace LogParser\Model;

class LogFileIterator implements \Iterator
{
    protected $file;
    protected $position = 0;
    protected $currentLine = null;

    public function __construct(\SplFileObject $file)
    {
        $this->file = $file;
        if (!$this->file->eof()) {
            $this->currentLine = $this->file->fgets();
        }
    }

    public function current()
    {
        return $this->currentLine;
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->currentLine = $this->file->fgets();
        $this->position++;
    }

    public function valid()
    {
        return !$this->file->eof();
    }

    public function rewind()
    {
        //throw new \Exception('Attempt to traverse the file backwards');
    }
}