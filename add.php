<?php

require_once('init.php');
require_once('db.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    //todo ���� ��� ������, �� ��������� ����� ������ � �� � ������� �������� �� index.php
    //todo �������� ������ �������� � ���������� ����� � ��������, �������� �� � �������

}

$projects = getProjects($con);

$layout = include_template('add.php', [
    'projects' => $projects,
    'errors' => $errors,
    'form_data' => $_POST
]);

echo $layout;
