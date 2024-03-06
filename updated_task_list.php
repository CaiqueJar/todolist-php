<?php foreach ($tasks as $task): ?>
    <?php $done = $task->status == 2 ? 'done' : '' ?>
    <li>
        <div class="task-name">
            <?php if ($done == 'done'): ?>
                <input type="checkbox" id="check-task-<?= $task->id ?>" class="check-task-done" value="<?= $task->id ?>"
                    checked>
            <?php else: ?>
                <input type="checkbox" id="check-task-<?= $task->id ?>" class="check-task-done" value="<?= $task->id ?>">
            <?php endif; ?>
            <label class="<?= $done ?> priority-<?= $task->id_priority ?>" id="status-<?= $task->id ?>"
                for="check-task-<?= $task->id ?>">
                <span class="task-text">
                    <?= $task->task ?>
                </span>
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
                    <?php foreach ($options as $option): ?>
                        <div class="priority change-priority priority-<?= $option->id ?>" data-priority="<?= $option->id ?>"
                            data-task="<?= $task->id ?>">
                            <i class="fa-solid fa-circle"></i>
                            <span>
                                <?= $option->priority ?>
                            </span>
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