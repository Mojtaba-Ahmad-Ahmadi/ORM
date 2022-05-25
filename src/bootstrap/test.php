<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database\PDODatabaseConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;

$config = Config::get('database', 'pdo_testing');

$pdoConnection = new PDODatabaseConnection($config);

$queryBuilder = new PDOQueryBuilder($pdoConnection->connect());

$queryBuilder->trancateAllTable();
