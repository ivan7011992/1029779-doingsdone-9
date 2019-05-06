<?php

require_once('helpers.php');
require_once('functions.php');

$show_complete_tasks = rand(0, 1);


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
$sql = "SELECT name_task AS task, date_start, status_task AS complete  FROM task";

$result = mysqli_query($con, $sql);

if (!$result) {
    $error = mysqli_error($con);
    print ("Ошибка MySQL:" . $error);
}  else {
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);


}
var_dump($tasks);
print (include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'complete'  => $tasks,
    'date_start' => $tasks

]));

/////////////////////////////////////

$con= mysqli_connect("localhost","root","","things");


if ($con == false) {
    if ($con == false) {
        print("Ошибка подключения:" . mysqli_connect_error());
    } else {
        print ("Cоединение усановлено");
    }
}

mysqli_set_charset($con, "utf8");


$sql = "SELECT name_project AS category FROM project ";

$result = mysqli_query($con, $sql);
if (!$result) {
    $error = mysqli_error($con);
    print ("Ошибка MySQL:" . $error);
} else {

    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


}
var_dump($categories);



$page_content = include_template('index.php', ['tasks' => $tasks,
                                        'show_complete_tasks' => $show_complete_tasks]);

print (include_template('layout.php', [' categories' => $categories,
                                             'show_complete_tasks' => $show_complete_tasks,
                                             'title' => 'Иван Васильев',
                                             'content' => $page_content,
                                              'tasks' => $tasks

]));
















// $tasks = [
//    [
//        'task' => 'Собеседование в IT-компании',
//        'date' => '01.12.2019',
//        'category' => 'Работа',
//        'complete' => 'Нет'
//    ],
//    [
//        'task' => 'Выполнеть тестовое задание',
//        'date' => '25.12.2018',
//        'category' => 'Работа',
//        'complete' => 'Нет'
//    ],
//    [
//        'task' => 'Сделать задание первого раздела',
//        'date' => '21.12.2019',
//        'category' => 'Учеба',
//        'complete' => 'Да'
//    ],
//
//    [
//        'task' => 'Встреча с другом',
//        'date' => '22.12.2018',
//        'category' => 'Входящие',
//        'complete' => 'Нет'
//    ],
//
//    [
//        'task' => 'Купить корм для кота',
//        'date' => 'Нет',
//        'category' => 'Домашние дела',
//        'complete' => 'Нет'
//    ],
//    [
//        'task' => 'Заказать пиццу',
//        'date' => 'Нет',
//        'category' => 'Домашние дела',
//        'complete' => 'Нет'
//    ]
//];
//$categories = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];

//

//$layout_content= include_template('layout.php', [ 'content' => $page_content,
//                                                        'tasks' => $tasks,
//                                                        'categories' =>  $categories,
//                                                        'title' => 'Иван Васильев'
//]);
//
//
//echo $layout_content;
//
