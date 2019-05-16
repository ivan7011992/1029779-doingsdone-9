<?php

require_once('init.php');
require_once('db.php');

function checkErrors($con)
{
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = '�������� ������ ���� �������';
    }

    // if project with id exist
    if (!projectExists($con, $_POST['project'])) {
        $errors['project'] = '������� �� ����������';
    }

    if (empty($_POST['date'])) {
        $errors['date'] = '���� ������ ���� ��������';
    } else {
        if (!is_date_valid($_POST['date'])) {
            $errors['date'] = '�������� ������ ����';
        } else {
            //todo
            if (strtotime($_POST['date']) < '') {
                $errors['date'] = '���� ������ ���� ������ ��� ����� �������';
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
        if (isset($_FILES['file'])) {
            $fileName = $_FILES['file']['name'];
            rename($_FILES['file']['tmp_name'], './uploads/' . $fileName);
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
    'title' => '���� ��������',
    'projects' => $projects,
    'projectTaskCount' => $projectTaskCount,
    'projectId' => null,
    'content' => $content,

]);

echo $layout;



