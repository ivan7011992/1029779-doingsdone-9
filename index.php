<?php

require_once('helpers.php');
require_once('functions.php');

$show_complete_tasks = rand(0, 1);
$project = [];


$con = mysqli_connect("localhost", "root", "", "things");

if ($con == false) {
    if ($con == false) {
        print("Ошибка подключения:" . mysqli_connect_error());
    } else {
        print ("Cоединение усановлено");
    }
}

mysqli_set_charset($con, "utf8");
//mysqli_options ($con,MYSQLI_OPT_INT_AND_FLOAT_NATIVE,1);
$sql = "SELECT name_task, date_start, status_task AS complete,project_id, name_project  FROM task t 
JOIN project p ON t.project_id = p.id";

$result1 = mysqli_query($con, $sql);

if (!$result1) {
    $error = mysqli_error($con);
    print ("Ошибка MySQL:" . $error);
} else {
    $tasks = mysqli_fetch_all($result1, MYSQLI_ASSOC);


}

print (include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'complete' => $tasks,
    'date_start' => $tasks,
    'project_id' => $tasks

]));


$con = mysqli_connect("localhost", "root", "", "things");

if ($con == false) {
    if ($con == false) {
        print("Ошибка подключения:" . mysqli_connect_error());
    } else {
        print ("Cоединение усановлено");
    }
}
mysqli_set_charset($con, "utf8");

$sql = "SELECT name_project  FROM project ";

$result = mysqli_query($con, $sql);
if (!$result) {
    $error = mysqli_error($con);
    print ("Ошибка MySQL:" . $error);
} else {

    $resalts = mysqli_fetch_all($result);
    $categories = [];

}
foreach ($resalts as $resalt) {
    $categories[] = $resalt[0];
}

$page_content = include_template('index.php', ['tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks]);

print (include_template('layout.php', [
    'categories' => $categories,
    'show_complete_tasks' => $show_complete_tasks,
    'title' => 'Иван Васильев',
    'content' => $page_content,
    'tasks' => $tasks

]));















