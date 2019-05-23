<?php
require_once('init.php');
require_once('db.php');

function checkErrorsAuth($con)
{
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = 'Введите имя';
    } else {
        if (empty($_POST['password'])) {
            $errors['password'] = 'Введите пароль';
        }

    }

}

$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = checkErrorsReg($con);
    if (count($errors) === 0) {

        $email = $_POST['email'];

        $sql = "SELECT * FROM tasks WHERE email = $email";

        $result = mysqli_query($con, $sql);}

        if (!$result) {
            $error = mysqli_error($con);
            echo "Ошибка MySQL:" . $error;
            die;
        }

        $mail = mysqli_fetch_all($result, MYSQLI_ASSOC);


        if (!$mail) {
            $errors['email'] = 'Email не найден';
        } else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "SELECT * FROM tasks WHERE pawword = $password";

            $result1 = mysqli_query($con, $sql);
        }

        if (!$result) {
            $error = mysqli_error($con);
            echo "Ошибка MySQL:" . $error;
            die;
        }
        $password= mysqli_fetch_all($result1, MYSQLI_ASSOC);

        if(!$password){
            session_start();


            if (isset($_SESSION[''])){

            }
            header("Location: /index.php", true, 301);
            exit();
        }


}

$content = include_template('auth.php', [
    'errors' => $errors,
    'form_data' => $_POST

]);


echo $content;



// получить запись из БД для указанного email (из формы)
// if(нету записи) then добавить ошибку в массив ошибок
// else проверить на совпадение хашей паролей (из базы и из формы)
// если хэши совпадают то создать сессию и редирект на главную
// else добавить ошибку


// вывести шаблон
