<?php
/**
 *
 * Получить все проекты.
 * @param $con Подключение к БД
 * @return array Проекты
 */
function getProjects($con)
{
    $sql = "SELECT * FROM projects ";

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
        $categories[] = $result;

    }

    return $categories;

}

/**
 *
 * Проверить на наличие задач и вывести их
 * @param $con Подключение к БД
 * @param int|null $projectId  Задача
 * @return array|null Массив задач
 */
function getTasks($con, $projectId = null)
{
    $sql = "SELECT name, date_start, completed, project_id  FROM tasks ";
    if($projectId !== null) {
        $sql .= (' WHERE project_id = ' . $projectId);
    }

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $tasks;

}

/**
 *
 * Проверка существования проекта
 * @param $con Подкючение к БД
 * @param $projectId Идентификатор проета
 * @return bool Проект есть или нет
 */

function projectExists($con, $projectId){
    $sql = 'SELECT COUNT(*) as projectsCount FROM projects WHERE id = ' . $projectId;

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }

    $projectsCount = (int) mysqli_fetch_assoc($result)['projectsCount'];

    return $projectsCount > 0;
}

/**
 * Количество задач для проекта
 *
 * @param $con
 * @return array|bool|mysqli_result Возращает массив с результатом выполнения запроса
 */



function projectTaskCount($con) {
    $sql = "select project_id, COUNT(*) as tasksCount from tasks GROUP BY project_id;";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $result = [];
    foreach ($rows as $row) {
        $result[$row['project_id']] = $row['tasksCount'];
    }

    return $result;
}
