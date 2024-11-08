<?php

class TaskManager
{
  private Database $database;

  public function __construct(Database $database)
  {
    $this->database = $database;
  }

  public function checkTaskStatus(): void
  {
    $query = "SELECT * FROM tasks WHERE execution_date <= NOW() AND status = 'pending'";

    $pdo = $this->database->getPdo();
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $tasks = $stmt->fetchAll();

    foreach ($tasks as $task) {
      $result = $this->executeTask($task['api_url'], $task['request_body']);

      $status = $result ? 'completed' : 'canceled';
      $status_description = $result ? 'The task was completed successfully' : 'Error while executing task';

      updateTaskStatus($this->database, $task['id'], $status, $status_description);

      if (!$result) {
        logError($this->database, $task['id'], 'Error while executing task');
      }
    }
  }

  public function executeTask(string $api_url, string $request_body): bool
  {
    try {
      $ch = curl_init($api_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
        throw new Exception('Error while executing task: ' . curl_error($ch));
      }

      curl_close($ch);

      return $response ? true : false;
    } catch (Exception $e) {
      return false;
    }
  }
}
