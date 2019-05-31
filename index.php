<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('init.php');
require_once('db.php');

session_start();

if (!empty($_GET['task_id']) && !empty($_GET['check'])) {
    if (!taskExist($con, $_GET['task_id'])) {
        http_response_code(404);
        die();
    }

    setTaskStatus($con, $_GET['task_id'], $_GET['check']);
}

$criteria = [];

$filterByDate = null;
if (!empty($_GET['filter-by-date'])) {
    $filterByDate = (int)$_GET['filter-by-date'];
    if (!in_array($filterByDate, [1, 2, 3, 4])) {
        $filterByDate = null;
    }
}
if ($filterByDate !== null) {
    $criteria['filByDate'] = $filterByDate;
}

$showComplete = null;
if (isset($_GET['show_completed'])) {
    $showComplete = (bool)$_GET['show_completed'];
}
$criteria['showComplete'] = $showComplete;

$projectId = null;
if (!empty($_GET['project_id'])) {
    $projectId = (int)$_GET['project_id'];
    if ($projectId > 0) {
        if (!projectExists($con, $projectId)) {
            http_response_code(404);
            die();
        }
        $criteria['project_id'] = $projectId;

    }
}

$search = $_GET ['search'] ?? '';
if (!empty($search)) {
    $criteria['search'] = $search;
}

$tasks = getTasks($con, $criteria);


$content = include_template('index.php', [
    'tasks' => $tasks,
    'projectId' => $projectId,
    'filterByDate' => $filterByDate,
    'showComplete' => $showComplete,
    'search' => $search,
]);


$layout = include_template('layout.php', array_merge([
    'title' => 'Иван Васильев',
    'projectId' => $projectId,
    'content' => $content,
], layoutVars($con)));

echo $layout;













