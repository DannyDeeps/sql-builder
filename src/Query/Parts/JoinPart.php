<?php

namespace Danny\MysqlQueryBuilder\Query\Parts;

class JoinPart
{
    public function __construct(
        private string $joinKey,
        private string $database,
        private string $table,
        private array $fields= []
    ) {}


    public function getReferencedFields()
    {
        if (empty($this->fields)) {
            return [ $this->database . '.' . $this->table . '.*' ];
        }

        return array_map(fn($field) => $this->database . '.' . $this->table . '.' . $field . ' as `' . $this->table . '.' . $field . '`', $this->fields);
    }


    public function getTableReference(string $mainReference)
    {
        return 'LEFT JOIN ' . $this->database . '.' . $this->table . ' ON ' . $this->database . '.' . $this->table . '.' . $this->joinKey . ' = ' . $mainReference;
    }
}