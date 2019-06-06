<?php
require_once('init.php');
require_once('db.php');

/**
 *
 * Валидация формы авторизиции.
 * @param $con
 * @return array
 */
function checkErrorsAuth($con)
{
    $errors = [];

    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите email';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите пароль';
    }

    return $errors;
}

/**
 * Получение  пользователя с заданным email.
 * @param $con
 * @param $email
 * @return |null
 */
function getUser($con, $email)
{
    $sql = sprintf("SELECT * FROM users WHERE email = '%s'", $email);
    $result = mysqli_query($con, $sql);
    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }

    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    switch (count($users)) {
        case 0:
            return null;
        case 1:
            return $users[0];
        default:
            return null;
    }
}

/**
 * Расширенная проверка авторизации пользователя.
 * @param $con
 * @return array
 */
function checkAuth($con)
{
    $errors = checkErrorsAuth($con);

    if (count($errors) !== 0) {
        return $errors;
    }

    $user = getUser($con, $_POST['email']);
    if ($user === null) {
        $errors['email'] = 'Пользователь с указанным email не найден';
        return $errors;
    }

    if (!password_verify($_POST['password'], $user['password'])) {
        $errors['password'] = 'Неверный пароль';
        return $errors;
    }

    session_start();
    $_SESSION['user'] = $user;
    header("Location: /index.php", true, 301);
    exit();

}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = checkAuth($con);
}

$content = include_template('auth.php', [
    'errors' => $errors,
    'form_data' => $_POST

]);


echo $content;
