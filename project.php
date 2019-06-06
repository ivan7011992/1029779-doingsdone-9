<?php

require_once('init.php');
require_once('db.php');

session_start();

function checkErrorsProject($con)
{

    $errors = [];

    $name = trim($_POST['name']);
    if (empty($name)) {
        $errors['name'] = 'Название проекта должно быть непустым';
    } else {
        if (projectWithNameExists($con, $_POST['name'])) {
            $errors['name'] = 'Проект с таким именем уже существует';
        }
    }

    return $errors;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = checkErrorsProject($con);

    if (count($errors) === 0) {
        $name = trim($_POST['name']);

        $sql = "INSERT INTO projects (name) VALUES (?)";
        $stmt = db_get_prepare_stmt($con, $sql, [
            $name,
        ]);
        $insertResult = mysqli_stmt_execute($stmt);

        header("Location: /index.php", true, 301);
        exit();
    }

}

$content = include_template('project.php', [
    'errors' => $errors,
    'form_data' => $_POST
]);

$layout = include_template('layout.php', array_merge([
    'title' => 'Иван Васильев',
    'content' => $content,
], layoutVars($con)));

echo $layout;
