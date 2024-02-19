<?php

require "connect.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $task_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

        delete('tasks', 'id', $task_id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}