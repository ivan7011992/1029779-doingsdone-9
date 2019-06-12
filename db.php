<?php
/**
 *
 * Получить все проекты.
 * @param $con Подключение к БД
 * @param $userId
 * @return array Проекты
 */
function getProjects($con, $userId)
{
    $sql = "SELECT * FROM projects where user_id = $userId";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $categories = [];



    foreach ($results as $result) {
        $categories[] = $result;

    }

    return $categories;

}

/**
 *
 * Проверить на наличие задач и вывести их
 * @param $con Подключение к БД
 * @param array $criteria
 * @return array|null Массив задач
 */
function getTasks($con, array $criteria = [])
{
    $sql = "SELECT * FROM tasks WHERE 1=1";

    if (!empty($criteria['project_id'])) {
        $sql .= sprintf(' AND project_id = %d', $criteria['project_id']);
    }
    if (!empty($criteria['user_id'])) {
        $sql .= sprintf(' AND user_id = %d', $criteria['user_id']);
    }
    if (!empty($criteria['filByDate'])) {
        switch ($criteria['filByDate']) {
            case 1:
                break;
            case 2:
                $sql .= " AND date_term = date (now())";
                break;
            case 3:
                $sql .= " AND date_term = date(now()  + INTERVAL 1 DAY)";
                break;
            case 4:
                $sql .= " AND date_term < date(now())";
                break;
            default:
                break;
        }
    }

    if (isset($criteria['showComplete']) && $criteria['showComplete'] !== null) {
        if ($criteria['showComplete'] === false) {
            $sql .= ' AND completed = 0';
        } else {
            // do nothing
        }
    } else {
        $sql .= ' AND completed = 0';
    }

    if (!empty($criteria['search'])) {
        $sql .= sprintf(" AND MATCH (name) AGAINST('%s')", $criteria['search']);
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
 * Проверка существования проекта.
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
 * Проверка существования проекта с указанным именем.
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


/**
 * Проверяет существование задачи с заданным Id.
 * @param $con
 * @param $taskId
 * @return bool
 */
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

/**
 * Устанавливает статус задачи.
 * @param $con
 * @param $taskId
 * @param $taskStatus
 */
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
 * Проверяет существование пользователя с данным  email.
 * @param $con
 * @param $email
 * @return bool
 */
function userWithEmailExists($con, $email)
{
    $sql = sprintf("SELECT COUNT(*) as usersCount FROM users WHERE email = '%s'",
        $email
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
 * @param $userId
 * @return array|bool|mysqli_result Возращает массив с результатом выполнения запроса
 */
function projectTaskCount($con, $userId)
{
    $sql = "select project_id, COUNT(*) as tasksCount from tasks where user_id = $userId GROUP BY project_id;";

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

/**
 * Фоормирует список переменных для основного шаблона.
 * @param $con
 * @return array
 */
function layoutVars($con)
{

    if (isset($_SESSION['user'])) {
        $projectTaskCount = projectTaskCount($con, $_SESSION ['user']['id']);
        $projects = getProjects($con, $_SESSION ['user']['id']);

        return [
            'logged' => array_key_exists('user', $_SESSION),
            'user' => $_SESSION['user'] ?? null,
            'projects' => $projects,
            'projectTaskCount' => $projectTaskCount,
        ];
    }

    return [
        'logged' => false
    ];
}

