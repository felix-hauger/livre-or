<?php

$pdo = new PDO('mysql:dbname=livreor;host=localhost;charset=utf8mb4', 'root', '');

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);