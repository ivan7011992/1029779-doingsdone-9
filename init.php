<?php

require_once('helpers.php');
require_once('functions.php');
require_once('db.php');

$con = mysqli_connect("localhost", "root", "", "things");

if ($con === false) {
    print("Ошибка подключения:" . mysqli_connect_error());
    die;
}

mysqli_set_charset($con, "utf8");