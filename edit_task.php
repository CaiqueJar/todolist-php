<?php

require "connect.php";

if(isset($_POST['task_name'])) {
    $task_name = filter_var($_POST['task_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $task_id = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);

    $task = update('tasks', ['task' => $task_name], ['id', $task_id]);
    $task = find('tasks', 'id', $task_id);
    echo json_encode($task);
}