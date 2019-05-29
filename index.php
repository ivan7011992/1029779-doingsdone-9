<?php
// error_reporting(-1);

require_once('init.php');
require_once('db.php');

$show_complete_tasks = $_GET['show_completed'];

session_start();

if (!empty($_GET['task_id']) && !empty($_GET['check'])) {
    if (!taskExist($con, $_GET['task_id'])) {
        http_response_code(404);
        die();
    }

    setTaskStatus($con, $_GET['task_id'], $_GET['check']);
}

$search = null;
if(!empty($_GET['search'])) {
    $search = $_GET['search'];
}

$filterByDate = null;
if (!empty($_GET['filter-by-date'])) {
    $filterByDate = (int)$_GET['filter-by-date'];
    if (!in_array($filterByDate, [1, 2, 3, 4])) {
        $filterByDate = null;
    }
}

$showComplete = false;
if (!empty($_GET['show_completed'])) {
    $showComplete = (bool)$_GET['show_completed'];
}

$projectId = null;
if (!empty($_GET['project_id'])) {
    $projectId = (int)$_GET['project_id'];
    if ($projectId > 0) {
        if (!projectExists($con, $projectId)) {
            http_response_code(404);
            die();
        }
        $tasks = getTasks($con, $projectId, $filterByDate, $showComplete, $search);
    } else {
        $tasks = getTasks($con, null, $filterByDate, $showComplete, $search);
    }
} else {
    $tasks = getTasks($con, null, $filterByDate, $showComplete, $search);
}


$content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'projectId' => $projectId,
    'filterByDate' => $filterByDate,
    'showComplete' => $showComplete,
    'search' => $search
]);


$layout = include_template('layout.php', array_merge([
    'title' => 'Иван Васильев',
    'projectId' => $projectId,
    'content' => $content,
], layoutVars($con)));

echo $layout;













