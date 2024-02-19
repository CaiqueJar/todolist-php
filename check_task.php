<?php

require "connect.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $task_id = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);

    $task = find('tasks', 'id', $task_id);
    if(!isset($task->id)) {
        exit();
    }

    $status = $task->status == 1 ? 2 : 1;

    update('tasks', ['status' => $status], ['id', $task->id]);

    echo json_encode(find('tasks', 'id', $task_id));
}