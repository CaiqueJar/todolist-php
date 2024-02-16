<?php

require "connect.php";

if(isset($_POST['submit'])) {
    $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
}