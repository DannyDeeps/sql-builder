<?php

namespace SqlBuilder\Query;

class Update {
  public function __construct(
    private string $database,
    private string $table,
    private array $fields
  ) {
  }
}
