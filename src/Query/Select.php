<?php

namespace SqlBuilder\Query;

 class Select {
  public function __construct(
    private string $database,
    private string $table,
    private array $fields = []
  ) {
  }

  public function __call(string $method, array $arguments) {
    switch (true) {
      case str_starts_with($method, 'get'):
        $prop = trim(strtolower(substr($method, 3)));

        if (property_exists($this, $prop)) {
          return $this->$prop;
        }

        throw new \Exception('Property does not exist: ' . $prop);
        break;
    }
  }

  public function getQueryString() {
    $queryStringParts = ['SELECT'];
    $queryStringParts[] = !empty($this->fields) ? implode(',', $this->fields) : '*';
    $queryStringParts[] = 'FROM ' . $this->database . '.' . $this->table;

    $queryString = implode(' ', $queryStringParts);

    return $queryString;
  }
}
