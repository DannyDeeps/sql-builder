<?php

require_once __DIR__ . '/../vendor/autoload.php';


// SELECT TEST
// $fields= [ 'id', 'name' ];

// $mysqlQuery= new Danny\MysqlQueryBuilder\Controller;
// $mysqlQuery
//     ->select('test', 'main_object', $fields)
//     ->unionSelect('test', 'sub_object', $fields);

// $queryString= $mysqlQuery->getQueryString();


// JOIN TEST
$mysqlQuery= new Danny\MysqlQueryBuilder\Controller;
$mysqlQuery
    ->select('test', 'main_object', [ 'id', 'name' ])
    ->join('main_object_id', 'test', 'sub_object', [ 'name' ])
    ->join('main_object_id', 'test2', 'main_object_details', [ 'detail' ]);

$queryString= $mysqlQuery->getQueryString();



$testCon= new PDO('mysql:host=localhost;', 'root', '');
$results= $testCon->query($queryString)->fetchAll(PDO::FETCH_OBJ);

$classes= [];

foreach ($results as $result) {
    $classProperties= [];

    foreach ($result as $classProp => $value) {
        list($class, $property)= explode('.', $classProp);

        $classProperties[$property]= $value;
    }

    $cl
}

die('<pre>'.print_r([
    'mysqlQuery' => $mysqlQuery,
    'query' => $queryString,
    'results' => $results,
    'classes' => $classes
], true).'</pre>');