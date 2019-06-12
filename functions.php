<?php


/**
 * Проверить,осталось меньше 24 часов до даты.
 * @param string $date Дата в виде строки
 * @return bool
 */
function check_date(string $date): bool
{
    $moment = strtotime($date);
    $now = time();

    $seconds = $moment - $now;
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

