<?php

function addTask(
  Database $database,
  string $request_body,
  string $api_url,
  string $execution_date,
  string $status = 'pending',
  string $status_description = ''
): string|false {
  $pdo = $database->getPdo();

  $query = "INSERT INTO tasks (request_body, api_url, execution_date, status, status_description) 
              VALUES (:request_body, :api_url, :execution_date, :status, :status_description)";

  try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':request_body', $request_body);
    $stmt->bindParam(':api_url', $api_url);
    $stmt->bindParam(':execution_date', $execution_date);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':status_description', $status_description);

    $stmt->execute();

    return $pdo->lastInsertId();
  } catch (Exception $e) {
    return false;
  }
}

function addTaskExample(): void
{
  $request_body = '{"param2":"value2"}';
  $api_url = 'https://example.com/api';
  $execution_date = '2024-12-01 12:00:00';
  $status = 'pending';
  $status_description = 'Awaiting execution';

  $database = new Database();

  $task_id = addTask($database, $request_body, $api_url, $execution_date, $status, $status_description);

  if ($task_id !== false)
    echo "Task added with ID: " . $task_id;
  else
    echo "Error occurred while adding the task";
}
