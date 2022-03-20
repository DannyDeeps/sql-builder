<?php

namespace Danny\MysqlQueryBuilder;

class Controller
{
    private int $queryType= 0;

    private Query\Select $selectQuery;
    private Query\Insert $insertQuery;
    private Query\Update $updateQuery;

    private array $unionQueries;


    public function select(string $database, string $table, array $fields= [])
    {
        if (!empty($this->selectQuery)) {
            throw new \Exception('Select query already defined, maybe the unionSelect() method was intended?');
        }

        $this->queryType= Query\Types::SELECT;

        $this->selectQuery= new Query\Select($database, $table, $fields);

        return $this;
    }


    public function unionSelect(string $database, string $table, array $fields= [])
    {
        if ($this->queryType !== Query\Types::SELECT) {
            throw new \Exception('Main query type is not a \'SELECT\', union not available.');
        }

        $this->selectQuery->addUnion($database, $table, $fields);

        return $this;
    }


    public function insert(string $database, string $table, array $fields= [])
    {
        if (!empty($this->insertQuery)) {
            throw new \Exception('Insert query already defined.');
        }

        $this->queryType= Query\Types::INSERT;

        $this->insertQuery= new Query\Insert($database, $table, $fields);

        return $this;
    }


    public function update(string $database, string $table, array $fields= [])
    {
        if (!empty($this->updateQuery)) {
            throw new \Exception('Update query already defined.');
        }

        $this->queryType= Query\Types::UPDATE;

        $this->updateQuery= new Query\Update($database, $table, $fields);

        return $this;
    }


    public function getQueryString()
    {
        if ($this->queryType === 0) {
            throw new \Exception('Cannot get query string, query not set yet.');
        }

        $query= match ($this->queryType) {
            Query\Types::SELECT => $this->selectQuery,
            Query\Types::INSERT => $this->insertQuery,
            Query\Types::UPDATE => $this->updateQuery,
            Query\Types::DELETE => $this->deleteQuery,

            default => throw new \Exception('Query type not recognized: ' . $this->queryType)
        };

        return $query->getQueryString();
    }
}