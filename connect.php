<?php

function connect() {
    $pdo = new \PDO('mysql:host=127.0.0.1;dbname=todolist;charset=utf8', 'root', '');
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

    return $pdo;
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
function update($table, $fields, $where) {
    if (!is_array($fields)) {
        $fields = (array) $fields;
    }

    $pdo = connect();

    $data = array_map(function ($field) {
        return "{$field} = :{$field}";
    }, array_keys($fields));

    $sql = "UPDATE {$table} SET ";
    
    $sql .= implode(',', $data);

    $sql .= " WHERE {$where[0]} = :{$where[0]}";

    $data = array_merge($fields, [$where[0] => $where[1]]);

    $update = $pdo->prepare($sql);
    $update->execute($data);

    return $update->rowCount();
}
function find($table, $field, $value) {
    $pdo = connect();

    $sql = "SELECT * FROM {$table} WHERE {$field} = :{$field}";

    $find = $pdo->prepare($sql);
    $find->bindValue($field, $value);
    $find->execute();

    return $find->fetch();
}

function all($table, $where = null, $operator = '=', $value = null) {
    $pdo = connect();

    $sql = "SELECT * FROM {$table}";

    if($where !== null && $operator !== null && $value !== null) {
        $allowed_operators = array('=', '>', '<', '>=', '<=', '<>', '!=', 'LIKE');
        if (!in_array($operator, $allowed_operators)) {
            throw new InvalidArgumentException('Invalid operator');
        }

        $sql .= " WHERE {$where} {$operator} :value";
    }

    $stmt = $pdo->prepare($sql);

    if ($value !== null) {
        $stmt->bindValue(':value', $value);
    }

    $stmt->execute();

    return $stmt->fetchAll();
}
function delete($table, $field, $id) {
    $pdo = connect();

    $sql = "DELETE FROM {$table} WHERE {$field} = :{$field}";
    $delete = $pdo->prepare($sql);
    $delete->bindValue($field, $id);
    return $delete->execute();
}