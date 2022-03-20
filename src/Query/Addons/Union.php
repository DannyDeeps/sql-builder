<?php

namespace Danny\MysqlQueryBuilder\Query\Addons;

class Union
{
    public function __construct(
        private string $database,
        private string $table,
        private array $fields= []
    ) {

    }

    public function getQueryString()
    {
        $queryStringParts= [ 'UNION SELECT' ];
        $queryStringParts[]= !empty($this->fields) ? implode(', ', $this->fields) : '*';
        $queryStringParts[]= 'FROM ' . $this->database . '.' . $this->table;

        return implode(' ', $queryStringParts);
    }
}