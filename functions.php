<?php

/**
 * Количество задач для данного проекта.
 * @param array $tasks Задачи
 * @param array $projectrow Список проектов
 * @return int
 */
function count_task(array $tasks, array $projectrow): int
{
    $counter = 0;
    $project_id = $projectrow['id'];

    foreach ($tasks as $task) {
        if ($project_id === $task['project_id']) {
            $counter++;
        }
    }

    return $counter;
}

/**
 * Проверить,осталось меньше 24 часов до даты.
 * @param string $date Дата в виде строки
 * @return bool
 */
function check_date(string $date): bool
{
    $moment = strtotime($date);
    $now = time();

    $seconds = $now - $moment;
    $hours = floor($seconds / 3600);

    return $hours <= 24;
}

/**
 * Превратить теги и специальные символы в обычный текст.
 * @param string $str Принимает строку
 * @return  string
 */
function esc(string $str)
{
    $text = htmlspecialchars($str);
    return $text;
}

