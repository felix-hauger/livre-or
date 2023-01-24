<?php

$db = parse_ini_file('config/database.ini');

$type = $db['type'];
$name = $db['name'];
$host = $db['host'];
$user = $db['user'];
$password = $db['password'];

//  Separated by commas: Data Source Name, database login, database password
$pdo = new PDO($type . ':dbname=' . $name . ';host=' . $host . ';charset=utf8mb4', $user, $password);

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);