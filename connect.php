<?php

function connect() {
    $connection = new PDO('mysql:todolist;host=127.0.0.1', 'root', '');
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $connection;
}
function create($table, $data) {
    $pdo = connect();

    if(!is_array($data)) {
        $data = (array) $data;
    }

    $sql = "INSERT INTO {$table}";
    $sql .= "(" . implode(',', array_keys($data)) . ")";
    $sql .= " VALUES(" . ':' . implode(',:', array_keys($data)) . ")";

    $insert = $pdo->prepare($sql);
    $success = $insert->execute($data);

    if (!$success)
        return false;

    $result = find($table, 'id', $pdo->lastInsertId());

    return $result;
}

function find($table, $field, $value) {
    $pdo = connect();

    $sql = "SELECT * FROM {$table} WHERE {$field} = :{$field}";

    $find = $pdo->prepare($sql);
    $find->bindValue($field, $value);
    $find->execute();

    return $find->fetch();
}