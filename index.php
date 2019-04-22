<?php
require_once ('helpers.php');
function esc($str) {
    $text = htmlspecialchars($str);
    return $text;
}

 $tasks = [
    [
        'task' => 'Собеседование в IT-компании',
        'date' => '01.12.18',
        'category' => 'Работа',
        'complete' => 'Нет'
    ],
    [
        'task' => 'Выполнеть тестовое задание',
        'date' => '25.12.2018',
        'category' => 'Работа',
        'complete' => 'Нет'
    ],
    [
        'task' => 'Сделать задание первого раздела',
        'date' => '21.12.2018',
        'category' => 'Учеба',
        'complete' => 'Да'
    ],

    [
        'task' => 'Встреча с другом',
        'date' => '22.12.2018',
        'category' => 'Входящие',
        'complete' => 'Нет'
    ],

    [
        'task' => 'Купить корм для кота',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'complete' => 'Нет'
    ],
    [
        'task' => 'Заказать пиццу',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'complete' => 'Нет'
    ]
];
$categories = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];

$show_complete_tasks = rand(0, 1);

$page_content= include_template('index.php',['tasks' => $tasks,
                                                   'show_complete_tasks' => $show_complete_tasks
]);

$layout_content= include_template('layout.php', [ 'content' => $page_content,
                                                        'tasks' => $tasks,
                                                        'categories' => $categories,
                                                        'title' => 'Иван Васильев'
]);



print($layout_content);
