<?php
require_once('init.php');
require_once('db.php');


function checkErrorsReg ()
{
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = '�������� ������ ���� �������';
    }

    if (empty($_POST['password'])) {
        $errors['name'] = '������� ������';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = '������� ������';
    }
    foreach ($_POST as $key => $value) {
        if ($key == "email") {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$key] = 'Email ������ ���� ����������';
            }
        }
    }
    return $errors;
}
$errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = checkErrors($con);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "INSERT INTO users (username, data_regist, email, password)
              VALUES (?,NOW(),?,?)";
        $stmt = db_get_prepare_stmt($con, $sql, [

            $name,
            $email,
            $password
        ]);

        $insertResult = mysqli_stmt_execute($stmt);


        header("Location: /index.php", true, 301);
        exit();
    }

$projectTaskCount = projectTaskCount($con);

$content = include_template('addreg.php', [
    'errors' => $errors,
    'form_data' => $_POST

    ]);


$layout = include_template('layout.php', [
    'title' => '���� ��������',
    'projects' => $projects,
    'projectTaskCount' => $projectTaskCount,
    'projectId' => null,
    'content' => $content,

]);

echo $layout;


