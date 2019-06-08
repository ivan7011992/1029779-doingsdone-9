<?php

require_once('init.php');
require_once('db.php');

session_start();

/**
 * Валидация формы добавления проекта.
 * @param $con
 * @return array
 */
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

        $sql = "INSERT INTO projects (name,user_id) VALUES (?,?)";
        $stmt = db_get_prepare_stmt($con, $sql, [
            $name, $_SESSION['user']['id']
        ]);
        $insertResult = mysqli_stmt_execute($stmt);

        if (!$insertResult) {
            $error = mysqli_error($con);
            echo "Ошибка MySQL:" . $error;
            die;
        }

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
    'projectId' => null,
    'content' => $content,
], layoutVars($con)));

echo $layout;
