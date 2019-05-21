<?php

require_once('init.php');
require_once('db.php');

function checkErrors($con)
{
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = 'Название должно быть непусто';
    }

    // if project with id exist
    if (!projectExists($con, $_POST['project'])) {
        $errors['project'] = 'Проекта не существует';
    }

    if (empty($_POST['date'])) {
        $errors['date'] = 'Дата должна быть непустая';
    } else {
        if (!is_date_valid($_POST['date'])) {
            $errors['date'] = 'Неверный формат даты';
        } else {
            //todo
            if (strtotime($_POST['date']) < '') {
                $errors['date'] = 'Дата должна быть больше или равна текущей';
            }
        }
    }

    return $errors;
}

$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = checkErrors($con);

    if (count($errors) === 0) {
        $fileName = '';
        if (isset($_FILES['file']['name'])) {
            $fileName = $_FILES['file']['name'];
            rename($_FILES['file']['tmp_name'], './uploads/' . $fileName);
            var_dump($_FILES['file']['name']);
         }

        $name = $_POST['name'];
        $project_id = $_POST['project'];
        $date = $_POST['date'];

        $sql = "INSERT INTO tasks (project_id, user_id, name, dowloads, date_start, completed, date_term)
              VALUES (?, 1,?, ?, NOW(),0,?)";
        $stmt = db_get_prepare_stmt($con, $sql, [
            $project_id,
            $name,
            $fileName,
            $date
        ]);
        $insertResult = mysqli_stmt_execute($stmt);


        header("Location: /index.php", true, 301);
        exit();
    }
}


$projects = getProjects($con);
$projectTaskCount = projectTaskCount($con);

$content = include_template('add.php', [
    'errors' => $errors,
    'form_data' => $_POST,
    'projects' => $projects,
]);


$layout = include_template('layout.php', [
    'title' => 'Иван Васильев',
    'projects' => $projects,
    'projectTaskCount' => $projectTaskCount,
    'projectId' => null,
    'content' => $content,

]);

echo $layout;



