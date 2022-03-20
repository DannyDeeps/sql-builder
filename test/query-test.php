<?php

require_once __DIR__ . '/../vendor/autoload.php';


// SELECT TEST
// $fields= [ 'id', 'name' ];

// $mysqlQuery= new Danny\MysqlQueryBuilder\Controller;
// $mysqlQuery
//     ->select('test', 'main_object', $fields)
//     ->unionSelect('test', 'sub_object', $fields);

// $queryString= $mysqlQuery->getQueryString();


// INSERT TEST
// $fields= [ 'id', 'name' ];

// $mysqlQuery= new Danny\MysqlQueryBuilder\Controller;
// $mysqlQuery
//     ->select('test', 'main_object', $fields)
//     ->unionSelect('test', 'sub_object', $fields);

// $queryString= $mysqlQuery->getQueryString();



$testCon= new PDO('mysql:host=localhost;', 'root', '');
$results= $testCon->query($queryString)->fetchAll(PDO::FETCH_OBJ);

die('<pre>'.print_r([
    'mysqlQuery' => $mysqlQuery,
    'query' => $queryString,
    'results' => $results
], true).'</pre>');