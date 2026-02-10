<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../routes/web.php";


$database = new Database();
$pdo = $database->connect();

Route::dispatch($pdo);