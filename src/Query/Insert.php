<?php

namespace SqlBuilder\Query;

class Insert {
  public function __construct(
    private string $database,
    private string $table,
    private array $fieldsAndNewValues
  ) {
  }
}
