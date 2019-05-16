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
$name=$_POST['name'];
$project_id=$_POST['project'];
$date =$_POST['date'];
     $sql = 'INSERT INTO tasks (project_id, user_id, name, dowloads, date_start , completed , date_term)
              VALUES ($project_id,1,"$name",Home.psd,?,?,$date)';

   header("'Location: http://localhost/index.php");






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
