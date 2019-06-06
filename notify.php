<?php
require_once 'init.php';
require_once 'vendor/autoload.php';

/**
 * �������� ������ ���������� �����
 * @param $con
 * @return array
 */
function getHotsTask($con)
{

    $sql = "select * from tasks where completed = 0 and date_term  >  (NOW() - interval 1 day)";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "������ MySQL:" . $error;
        die;
    }
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $userTasks = [];
    foreach ($result as $row) {
        $userId = $row['user_id'];

        if (isset($userTasks[$userId])) {
            $userTasks[$userId][] = $row;
        } else {
            $userTasks[$userId] = [];
            $userTasks[$userId][] = $row;
        }
    }

    return $userTasks;

}

/**
 * �������� ���������� � ������������
 * @param $con
 * @param $userId
 * @return mixed
 */
function getUserInfo($con, $userId)
{
    $sql = sprintf("select * from users where id = %d", $userId);

    $result = mysqli_query($con, $sql);

    if (!$result) {
        $error = mysqli_error($con);
        echo "������ MySQL:" . $error;
        die;
    }
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result[0];
}


/**
 * ���������� ������ �������������
 * @param $con
 * @param $userId
 * @param $tasks
 */
function sendMail($con, $userId, $tasks)
{
    $user = getUserInfo($con, $userId);

    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
        ->setUsername('dcb8473d83b8f2')
        ->setPassword('1b6cc0296f84a9');

    $mailer = new Swift_Mailer($transport);

    $body = sprintf('���������, %s. ', $user['username']);
    foreach ($tasks as $task) {
        $body .= sprintf('� ��� ������������� ������ %s �� %s', $task['name'], $task['date_term']);
    }

    $message = (new Swift_Message('����������� �� ������� ����� � �������'))
        ->setFrom(['keks@phpdemo.ru' => 'keks@phpdemo.ru'])
        ->setTo([$user['email']])
        ->setBody($body);

    $result = $mailer->send($message);
    if ($result) {
        echo sprintf('Sended mail to %s', $user['username']);
    }

}

$userTasks = getHotsTask($con);
foreach ($userTasks as $userId => $tasks) {
    sendMail($con, $userId, $tasks);
}
