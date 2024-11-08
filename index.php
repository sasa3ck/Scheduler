<?php

require './config/database.php';
require './taskManager.php';

require './API/addTask.php';
require './API/updateTaskStatus.php';
require './API/logError.php';
require './API/sendEmailNotification.php';

if (!class_exists('Database')) {
  die('Class Database not found');
}

$database = new Database();
$taskManager = new TaskManager($database);

# Пример использования TaskManager
// $taskManager->checkTaskStatus();

# Пример добавления задачи
// addTaskExample();

# или
// try {
//   $task_id = addTask($database, $request_body, $api_url, $execution_date, $status, $status_description);
//   echo "Task added with ID: " . $task_id . "<br>";
// } catch (Exception $e) {
//   echo "Error: " . $e->getMessage();
// }

# Пример обновления статуса задачи
// updateTaskStatusExample();

# Пример логирования ошибки
// logErrorExample();

# Пример отправки уведомления по email
// sendEmailNotificationExample();
