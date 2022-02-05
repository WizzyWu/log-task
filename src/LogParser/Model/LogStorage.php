<?php
namespace LogParser\Model;

use LogParser\Interfaces;

Class LogStorage implements Interfaces\LogStorage {
    protected $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function getIterator()
    {
        return new LogCollectionIterator($this);
    }

    public function sortItemsByOccurrences () {
        usort($this->items, function ($a, $b)  {
            return $a->getOccurrences() < $b->getOccurrences();
        });
    }

    public function sortItemsByUniqueOccurrences () {
        usort($this->items, function ($a, $b)  {
            return $a->getUniqueOccurrences() < $b->getUniqueOccurrences();
        });
    }

    public function addLogRecord(Interfaces\LogRecord $logRecord)
    {
        if ($this->checkIfIdExists($logRecord->getId())) {
            throw new \Exception('An record with the same ID already exists in the storage');
        }
        $this->items[$logRecord->getId()] = $logRecord;
    }

    public function getLogRecordById($logRecordId) {
        if (!$this->checkIfIdExists($logRecordId)) {
            throw new \Exception('An record with requested id doesn\'t exists in the storage');
        }
        return $this->items[$logRecordId];
    }

    public function checkIfIdExists ($logRecordId) {
        return isset($this->items[$logRecordId]);
    }
}
