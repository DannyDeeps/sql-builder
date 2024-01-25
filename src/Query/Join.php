<?php

namespace SqlBuilder\Query;

class Join {
  private array $joinParts;


  public function __construct(
    private Select $selectQuery
  ) {
  }


  public function getSelectQuery() {
    return $this->selectQuery;
  }


  public function setSelectQuery(Select $selectQuery) {
    $this->selectQuery = $selectQuery;

    return $this;
  }


  public function addJoin(string $joinKey, string $database, string $table, array $fields = []) {
    $this->joinParts[] = new Parts\JoinPart($joinKey, $database, $table, $fields);

    return $this;
  }


  public function getQueryString() {
    $namedFields = $this->_getJoinFields();
    $tableReferences = $this->_getJoinTables();

    $queryString = implode(' ', ['SELECT', $namedFields, 'FROM', $this->_getSelectTable(), $tableReferences]);

    return $queryString;
  }


  private function _getJoinFields() {
    $joinFields = $this->_getSelectReferencedFields();

    foreach ($this->joinParts as $joinPart) {
      $joinFields = array_merge($joinFields, $joinPart->getReferencedFields());
    }

    return implode(', ', $joinFields);
  }


  private function _getJoinTables() {
    $tableReferences = [];

    foreach ($this->joinParts as $joinPart) {
      $tableReferences[] = $joinPart->getTableReference($this->_getSelectPrimaryKeyReference());
    }

    return implode(' ', $tableReferences);
  }


  private function _getSelectTable() {
    return implode('.', [
      $this->selectQuery->getDatabase(),
      $this->selectQuery->getTable()
    ]);
  }


  private function _getSelectReferencedFields() {
    return array_map(fn ($field) => implode('.', [
      $this->selectQuery->getDatabase(),
      $this->selectQuery->getTable(),
      $field
    ]) . ' as `' . $this->selectQuery->getTable() . '.' . $field . '`', $this->selectQuery->getFields());
  }


  private function _getSelectPrimaryKeyReference() {
    return $this->_getSelectTable() . '.id';
  }
}
