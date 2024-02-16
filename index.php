<!DOCTYPE html>
<html lang="en">
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
        <li>
            <input type="checkbox">
            <span>Tarefa 1</span>
        </li>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let btnCreate = document.getElementById('btn-create');

            btnCreate.addEventListener('click', function() {
                let modalCreate = document.getElementById('modal-create');
                modalCreate.classList.toggle("active");
            });
        });
    </script>
</body>
</html>