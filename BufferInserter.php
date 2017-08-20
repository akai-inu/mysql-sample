<?php

class BufferInserter
{
    public function __construct(Medoo\Medoo $medoo, string $table, int $capacity = 10000)
    {
        $this->medoo = $medoo;
        $this->table = $table;
        $this->capacity = $capacity;
        $this->buffer = [];
        $this->total = 0;
    }

    public function push(array $record)
    {
        $this->buffer[] = $record;
        $this->total++;
        $this->execute();
    }

    public function finish()
    {
        $this->execute(true);
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    private function execute(bool $force = false)
    {
        if (!$force && $this->capacity >= count($this->buffer)) {
            return;
        }

        $this->medoo->insert($this->table, $this->buffer);
        $this->buffer = [];
    }
}