<?php

require "connect.php";

if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['task_id']) {
    $task_id = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);
    $priority_id = filter_var($_POST['priority_id'], FILTER_SANITIZE_NUMBER_INT);

    $task = find('tasks', 'id', $task_id);
    if(!isset($task->id)) {
        exit();
    }

    update('tasks', [
        'id_priority' => $priority_id
    ], ['id', $task_id]);

    $tasks = orderBy('tasks', 'id_priority', 'ASC');
    $options = orderBy('priorities', 'id', 'ASC');

    include "updated_task_list.php";
}


?>