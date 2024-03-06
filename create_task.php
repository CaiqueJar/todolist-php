<?php

require "connect.php";

if(isset($_POST['submit'])) {
    $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
    if ($task == '') {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $status = 1;
    $priority = find('priorities', 'priority', 'Normal');

    $item = create('tasks', [
        'task' => $task,
        'status' => $status,
        'id_priority' => $priority->id
    ]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}