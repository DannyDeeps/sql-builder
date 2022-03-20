<?php

namespace Danny\MysqlQueryBuilder\Query;

class Types
{
    const SELECT= 1;
    const INSERT= 2;
    const UPDATE= 3;
    const DELETE= 4;
    const JOIN=   5;
    const UNION=  6;


    public static function getName(int $typeId)
    {
        return match($typeId) {
            self::SELECT => 'select',
            self::INSERT => 'insert',
            self::UPDATE => 'update',
            self::DELETE => 'delete',
            self::JOIN   => 'join',
            self::UNION  => 'union',

            default => throw new \Exception('Query type ID not recognised: ' . $typeId)
        };
    }
}