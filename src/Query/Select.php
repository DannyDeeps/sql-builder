<?php

namespace Danny\MysqlQueryBuilder\Query;

class Select
{
    private array $unionQueries= [];


    public function __construct(
        private string $database,
        private string $table,
        private array $fields= []
    ) {}


    public function addUnion(string $database, string $table, array $fields= [])
    {
        $this->unionQueries[]= new Addons\Union($database, $table, $fields);
    }


    public function getQueryString()
    {
        $queryStringParts= [ 'SELECT' ];
        $queryStringParts[]= !empty($this->fields) ? implode(',', $this->fields) : '*';
        $queryStringParts[]= 'FROM ' . $this->database . '.' . $this->table;

        $queryString= implode(' ', $queryStringParts);

        if (!empty($this->unionQueries)) {
            $unionQueries= [];
            foreach ($this->unionQueries as $unionQuery) {
                $unionQueries[]= $unionQuery->getQueryString();
            }

            $queryString= $queryString . ' ' . implode(' ', $unionQueries);
        }

        return $queryString;
    }
}