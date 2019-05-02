<?php

/**
 *
 * Количество задач для категории.
 * @param array $tasks Задачи
 * @param string $category Список категорий
 * @return int
 */
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
 * Проверить,осталось меньше 24 часов до даты.
 * @param $date  string Дата в виде строки
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
 * @param $str Принимает строку
 * @return  string
 */
function esc (string $str)
{
    $text = htmlspecialchars($str);
    echo $text;
}
