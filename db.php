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
 * @param int|null $projectId Задача
 * @return array|null Массив задач
 */
function getTasks($con, $projectId = null, $filByDate)
{
    $sql = "SELECT * FROM tasks ";
    if ($projectId !== null) {
        $sql .= (' WHERE project_id = ' . $projectId);
    }
    switch($filByDate) {
        case 1:

            break;
        case 2:
          //  $sql ,= 'AND date_start';
         $sql =  "SELECT * FROM tasks WHERE date_term = date_format(now(), '%y-%m-%d')";
            break;
        case 3:
         $sql = "SELECT * FROM tasks WHERE date_term = date_format(now()  + INTERVAL 1 DAY , '%y-%m-%d' )";
            break;
        case 4:
         $sql = "SELECT * FROM tasks WHERE   date_format(now() , '%y-%m-%d' ) > date_term";
            break;
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
function projectExists($con, $projectId)
{
    $sql = 'SELECT COUNT(*) as projectsCount FROM projects WHERE id = ' . $projectId;

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }

    $projectsCount = (int)mysqli_fetch_assoc($result)['projectsCount'];

    return $projectsCount > 0;
}

/**
 *
 * Проверка существования проекта с указанным именнм
 * @param $con Подкючение к БД
 * @param $projectName Идентификатор проета
 * @return bool Проект есть или нет
 */
function projectWithNameExists($con, $projectName)
{
    $sql = sprintf("SELECT COUNT(*) as projectsCount FROM projects WHERE name='%s'", $projectName);

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }

    $projectsCount = (int)mysqli_fetch_assoc($result)['projectsCount'];

    return $projectsCount > 0;
}

function taskExist($con, $taskId)
{
    $sql = sprintf("SELECT COUNT(*) as tasksCount FROM tasks WHERE id=%d", $taskId);

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }

    $tasksCount = (int)mysqli_fetch_assoc($result)['tasksCount'];

    return $tasksCount > 0;
}

function setTaskStatus($con, $taskId, $taskStatus)
{
    $sql = 'UPDATE tasks set completed=? where id=?';

    $stmt = db_get_prepare_stmt($con, $sql, [
        $taskStatus,
        $taskId,
    ]);

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
}

/**
 *
 * Проверяет существование пользователя в базе.
 * @param $con
 * @param $username
 * @return bool
 */

function userExists($con, $username)
{
    $sql = sprintf("SELECT COUNT(*) as usersCount FROM users WHERE username = '%s'",
        $username
    );

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }

    $usersCount = (int)mysqli_fetch_assoc($result)['usersCount'];

    return $usersCount > 0;
}


/**
 * Количество задач для проекта
 *
 * @param $con
 * @return array|bool|mysqli_result Возращает массив с результатом выполнения запроса
 */
function projectTaskCount($con)
{
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

function layoutVars($con)
{
    $projectTaskCount = projectTaskCount($con);
    $projects = getProjects($con);

    return [
        'logged' => array_key_exists('user', $_SESSION),
        'user' => $_SESSION ['user'],
        'projects' => $projects,
        'projectTaskCount' => $projectTaskCount,
    ];
}

