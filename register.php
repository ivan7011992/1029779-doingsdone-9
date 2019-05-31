<?php
require_once('init.php');
require_once('db.php');


function checkErrorsReg($con)
{
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = 'Название должно быть непусто';
    } else {
        if (userExists($con, $_POST['name'])) {
            $errors['name'] = 'Пользователь уже существует';
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите паполь';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите пароль';
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email должен быть корректным';
        }
        else{
            if(userWithEmailExists($con, $_POST['email'])){
                $errors['email'] = 'Пользователь с таокй почтой уже существет';

            }

        }
    }

    return $errors;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = checkErrorsReg($con);
    if (count($errors) === 0) {


        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, data_regist, email, password) VALUES (?,NOW(),?,?)";
        $stmt = db_get_prepare_stmt($con, $sql, [
            $name,
            $email,
            $password
        ]);

        $insertResult = mysqli_stmt_execute($stmt);


        header("Location: /index.php", true, 301);
        exit();
    }
}


$content = include_template('register.php', [
    'errors' => $errors,
    'form_data' => $_POST

]);


echo $content;


