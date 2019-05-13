<?php
/**
 * Получить все проекты.
 *
 * @param $con
 * @return array
 */

function getProjects($con)
{
    $sql = "SELECT name FROM projects ";

    $result = mysqli_query($con, $sql);
        if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    } else {
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $categories = [];
    }

    foreach ($results as $result) {
        $categories[] = $result['name'];
           }

    return $categories;

}

/**
 * @param $con
 * @return array|null
 */
function getTasks($con)
{
    $sql = "SELECT name , date_start,  completed ,project_id  FROM tasks ";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
            $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $tasks;

}
