<?php

/**
 * количество задач для категории
 * @param array $tasks
 * @param string $category
 * @return in */

function count_task(array $tasks, string $category): int
{
    $counter = 0;
    foreach ($tasks as $key => $item) {
        if ($category === $item['category']) {
            $counter++;
        }
    }

    return $counter;
}

/**
 * Проверить,осталось меньше 24 часов до даты
 * @param $date
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
 * Превратить теги и специальные символы в обычный текст
 * @param $str
 */
function esc($str)
{
    $text = htmlspecialchars($str);
    echo $text;
}
