<?php

namespace Danny\MysqlQueryBuilder\Query;

class Update
{
    public function __construct(
        private string $database,
        private string $table,
        private array $fields
    ) {}
}
