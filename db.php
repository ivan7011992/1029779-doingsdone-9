<?php
/**
 *
 * Получить все проекты.
 * @param $con
 * @return array
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
 * @param $con
 * @param int|null $projectId
 * @return array|null
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
