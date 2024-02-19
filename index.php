<?php

require "connect.php";
$tasks = all('tasks');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <button id="btn-create">Cadastrar tarefa</button>
    <hr>
    <ul>
        <?php foreach($tasks as $task): ?>
            <?php $done = $task->status == 2 ? 'done' : '' ?>
            <li class="status <?= $done ?>" id="status-<?= $task->id ?>">
                <?php if($done == 'done'): ?>
                    <input type="checkbox" id="check-task-<?= $task->id ?>" class="check-task-done" value="<?= $task->id ?>" checked>
                <?php else: ?>
                    <input type="checkbox" id="check-task-<?= $task->id ?>" class="check-task-done" value="<?= $task->id ?>">
                <?php endif; ?>
                <label for="check-task-<?= $task->id ?>"><?= $task->task ?></label>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="modal create" id="modal-create">
        <div class="overlay"></div>
        <div class="modal-content">
            <form action="create_task.php" method="POST">
                <h2>Criar nova tarefa</h2>
                <div class="input">
                    <label for="task">Nome da tarefa:</label>
                    <input type="text" name="task" id="task">
                </div>

                <input type="submit" value="Enviar" name="submit">
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#btn-create').click(function() {
                $('#modal-create').toggleClass("active");
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
        });
    </script>
</body>
</html>