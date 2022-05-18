<?php
require('src/Helpers/Config.php');
use App\Helpers\Config;

require_once "./vendor/autoload.php";

$result = Config::get('database','pdo');

var_dump($result);

