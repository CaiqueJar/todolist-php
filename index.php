<?php
require "connect.php";
$tasks = orderBy('tasks', 'id_priority', 'ASC');
$options = orderBy('priorities', 'id', 'ASC');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <h1>Todo List</h1>
        <form action="create_task.php" method="POST">
            <div class="input">
                <!-- <label for="task">Nome da tarefa:</label> -->
                <input type="text" name="task" id="task" placeholder="Nome da nova tarefa:">
                <input type="submit" value="Enviar" name="submit">
            </div>
        </form>

        <ul class="tasks-list" id="tasks-list">
            <?php foreach($tasks as $task): ?>
                <?php $done = $task->status == 2 ? 'done' : '' ?>
                <li>
                    <div class="task-name">
                        <?php if($done == 'done'): ?>
                            <input type="checkbox" id="check-task-<?= $task->id ?>" class="check-task-done" value="<?= $task->id ?>" checked>
                        <?php else: ?>
                            <input type="checkbox" id="check-task-<?= $task->id ?>" class="check-task-done" value="<?= $task->id ?>">
                        <?php endif; ?>
                        <label class="<?= $done ?> priority-<?= $task->id_priority ?>" id="status-<?= $task->id ?>" for="check-task-<?= $task->id ?>">
                            <span class="task-text"><?= $task->task ?></span>
                            <input type="text" class="task-edit" value="<?= $task->task ?>" data-id="<?= $task->id ?>">
                        </label>
                    </div>
                    <div class="options">
                        <a class="del-button" data-id="<?= $task->id ?>">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                        <a class="edit-button" data-id="<?= $task->id ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a class="priorities-button" data-id="<?= $task->id ?>">
                            <i class="fa-solid fa-ellipsis"></i>
                            <div class="tooltip">
                                <?php foreach($options as $option): ?>
                                    <div class="priority change-priority priority-<?= $option->id ?>" data-priority="<?= $option->id ?>" data-task="<?= $task->id ?>">
                                        <i class="fa-solid fa-circle"></i>
                                        <span><?= $option->priority ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </a>
                    </div>
                </li>

                <div class="modal del" id="modal-del-<?= $task->id ?>">
                    <div class="overlay"></div>
                    <div class="modal-content">
                        <form action="delete_task.php" method="POST">
                            <h2>Deletar esta tarefa</h2>
                            <input type="hidden" name="id" value="<?= $task->id ?>">
                            <input class="btn btn-primary" type="submit" value="Enviar" name="submit">
                        </form>
                    </div>
                </div>

            <?php endforeach; ?>
        </ul>
    </main>
    

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function init() {
            $('.del-button').click(function(e) {
                e.preventDefault();
                let task_id = $(this).attr('data-id');
                $('#modal-del-'+task_id).toggleClass('active');
            });
            
            $('.edit-button').click(function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                let task_id = $(this).attr('data-id');
                $('#status-'+task_id).find('input').toggleClass('active');
            });

            $('.task-edit').blur(function(e) {
                let task_id = $(this).attr('data-id');
                let task_name = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "edit_task.php",
                    data: {
                        task_name: task_name,
                        task_id: task_id
                    },
                    success: function(response) {
                        let obj = JSON.parse(response);
                        $('#status-' + obj['id']).find('.task-text').text(obj.task)
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
                $(this).toggleClass('active');
            });

            $('.priorities-button').click(function() {
                $(this).toggleClass('active');
            });

            $('.change-priority').click(function() {
                let task_id = $(this).attr('data-task');
                let priority_id = $(this).attr('data-priority');
                 $.ajax({
                    type: "POST",
                    url: "change_task_priority.php",
                    data: {task_id: task_id, priority_id: priority_id},
                    success: function(response){
                        $('#tasks-list').html(response)
                        init();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            $('.modal .overlay').click(function() {
                $('.modal').removeClass('active');
            });

            $('.check-task-done').change(function() {
                let task_id = $(this).val();
                 $.ajax({
                    type: "POST",
                    url: "check_task.php",
                    data: {task_id: task_id},
                    success: function(response){
                        let task = JSON.parse(response);
                        $('#status-'+task['id']).toggleClass('done');
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        }

        $(document).ready(function() {
            init();
        });
    </script>
</body>
</html>