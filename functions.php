<?php

function count_task(array $tasks, string $category)
{
    $counter = 0;
    foreach ($tasks as $key => $item) {
        if ($category === $item['category']) {
            $counter++;
        }
    }

    return $counter;
}

function checkdata($date)
{
    $date_task= strtotime( $date);
    $date_difference= $date_task-time();
    $hours= floor ($date_difference/3600);
    if ( $hours<=24) {
        $class_on = 'task--important';
    }

    return $class_on;
}

function esc($str)
{
    $text = htmlspecialchars($str);
    return $text;
}
