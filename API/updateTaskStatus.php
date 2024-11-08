<?php

function updateTaskStatus(Database $database, int $task_id, string $status, string $status_description): void
{
  try {
    $pdo = $database->getPdo();

    $query = "UPDATE tasks SET status = :status, status_description = :status_description WHERE id = :task_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':task_id', $task_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':status_description', $status_description);

    $stmt->execute();

    if ($stmt->rowCount() === 0) {
      echo "No task updated, check if the task ID exists";
    }
  } catch (\PDOException $e) {
    error_log("Error updating task status: " . $e->getMessage());
    throw new Exception("Database update failed, please try again later");
  }
}

function updateTaskStatusExample(): void
{
  $task_id = 12;
  $new_status = 'completed';
  $status_description = 'The task was successfully completed';

  $database = new Database();

  updateTaskStatus($database, $task_id, $new_status, $status_description);

  echo "Task status updated";
}
