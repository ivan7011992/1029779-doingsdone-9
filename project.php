<?php

require_once('init.php');
require_once('db.php');

function checkErrorsProject($con)
{

    $errors = [];

    if (empty($_POST['name'])) {
        $errors['project'] = 'Проект не задан';
    } else {
        if (!projectExists($con, $_POST['project'])) {
            $errors['name'] = 'Проекта не существует';
        }
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors  =checkErrorsProject($con);
    if (count($errors) === 0) {

        $name = $_POST['name'];



        $sql = "INSERT INTO projects (name)
              VALUES (name)";
        $stmt = db_get_prepare_stmt($con, $sql, [

            $name,

        ]);
        $insertResult = mysqli_stmt_execute($stmt);


        header("Location: /index.php", true, 301);
        exit();
    }

}

$content = include_template('project.php', array_merge ([
    'errors' => $errors,
    'form_data' => $_POST, ], layoutVars($con)));