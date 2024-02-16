<?php

require "connect.php";

var_dump(create('asd', ['name' => 'teste', 'idade' => 12]));
die();

if(isset($_POST['submit'])) {
    $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
}