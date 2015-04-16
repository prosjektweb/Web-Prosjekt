<?php

global $db;

try {
    $db = new PDO("mysql:host=$SQL_SERVER;dbname=$SQL_DATABASE", $SQL_USERNAME, $SQL_PASSWORD);
} catch (PDOException $e) {
    //throw new Exception($e->getMessage(), $e->getCode);
    printf($e->getMessage());
}

function getDB() {
    global $db;
    return $db;
}
