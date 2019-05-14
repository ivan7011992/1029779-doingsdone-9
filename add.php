<?php

require_once('init.php');
require_once('db.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['name'])) {
        $errors['name'] = 'Ќазвание должно быть непусто';
    }

    // if project with id exist
    if (!projectExists($con, $_POST['project'])) {
        $errors['project'] = 'ѕроекта не существует';
    }

    if (empty($_POST['date'])) {
        $errors['date'] = 'ƒата должна быть непуста€';
    } else {
        if (!is_date_valid($_POST['date'])) {
            $errors['date'] = 'Ќеверный формат даты';
        } else {
            //todo
            if (strtotime($_POST['date']) < '') {
                $errors['date'] = 'ƒата должна быть больше или равна текущей';
            }
        }
    }

    //todo если нет ошибок, то сохранить новую задачу в Ѕƒ и сделать редирект на index.php
    //todo получить список проектов и количество задач в проектах, выводить их в шаблоне

}

$projects = getProjects($con);

$layout = include_template('add.php', [
    'projects' => $projects,
    'errors' => $errors,
    'form_data' => $_POST
]);

echo $layout;
