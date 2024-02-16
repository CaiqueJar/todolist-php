<?php

function connect() {
    $connection = new PDO('mysql:todolist;host=127.0.0.1', 'root', '');
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $connection;
}
function create($table, $data) {

    $pdo = connect();

    $query = "INSERT INTO {$table}() VALUES ";

    return $pdo;
}