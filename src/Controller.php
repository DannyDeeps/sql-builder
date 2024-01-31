<?php

namespace SqlBuilder;

class Controller {
  private int $queryType = 0;

  private Query\Select $selectQuery;
  private Query\Insert $insertQuery;
  private Query\Update $updateQuery;
  private Query\Delete $deleteQuery;
  private Query\Join   $joinQuery;


  public function select(string $database, string $table, array $fields = []) {
    if (!empty($this->selectQuery)) {
      throw new \Exception('Select query already defined, maybe the unionSelect() method was intended?');
    }

    $this->queryType = Query\Types::SELECT;

    $this->selectQuery = new Query\Select($database, $table, $fields);

    return $this;
  }


  public function join(string $joinKey, string $database, string $table, array $fields = []) {
    if (!in_array($this->queryType, [Query\Types::SELECT, Query\Types::JOIN])) {
      throw new \Exception('join() can only be used with select queries but current query type is: ' . Query\Types::getName($this->queryType));
    }

    $this->queryType = Query\Types::JOIN;

    if (empty($this->joinQuery)) {
      $this->joinQuery = new Query\Join($this->selectQuery);
    }

    $this->joinQuery->addJoin($joinKey, $database, $table, $fields);

    return $this;
  }


  public function getQueryString() {
    if ($this->queryType === 0) {
      throw new \Exception('Cannot get query string, query not set yet.');
    }

    $query = match ($this->queryType) {
      Query\Types::SELECT => $this->selectQuery,
      Query\Types::INSERT => $this->insertQuery,
      Query\Types::UPDATE => $this->updateQuery,
      Query\Types::DELETE => $this->deleteQuery,
      Query\Types::JOIN   => $this->joinQuery,

      default => throw new \Exception('Query type not recognized: ' . $this->queryType)
    };

    return $query->getQueryString();
  }
}
