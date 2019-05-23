<?php
// error_reporting(-1);

require_once('init.php');
require_once('db.php');

$show_complete_tasks = rand(0, 1);

session_start();

$projectId = null;
if (!empty($_GET['project_id'])) {
    $projectId = (int)$_GET['project_id'];
    if ($projectId > 0) {
        if (!projectExists($con, $projectId)) {
            http_response_code(404);
            die();
        }
        $tasks = getTasks($con, $projectId);
    } else {
        $tasks = getTasks($con);
    }
} else {
    $tasks = getTasks($con);
}


$content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);


$layout = include_template('layout.php', array_merge([
    'title' => 'Иван Васильев',
    'projectId' => $projectId,
    'content' => $content,
], layoutVars($con)));

echo $layout;













