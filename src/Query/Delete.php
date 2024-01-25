<?php

namespace SqlBuilder\Query;

class Delete {
  public function __construct(
    private string $database,
    private string $table,
    private array $fieldsAndNewValues
  ) {
  }
}
