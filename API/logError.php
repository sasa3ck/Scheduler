<?php

function logError(Database $database, int $task_id, string $error_message): void
{
  try {
    $pdo = $database->getPdo();

    $query = "INSERT INTO logs (task_id, error_message) VALUES (:task_id, :error_message)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':task_id', $task_id);
    $stmt->bindParam(':error_message', $error_message);

    $stmt->execute();

    if ($stmt->rowCount() === 0) {
      echo "No log entry added. Please check the database";
    }
  } catch (\PDOException $e) {
    error_log("Error logging error: " . $e->getMessage());
    throw new Exception("Failed to log error, please try again later");
  }
}

function logErrorExample(): void
{
  $task_id = 14;
  $error_message = 'An error occurred while executing your request';

  $database = new Database();

  try {
    logError($database, $task_id, $error_message);
    echo "Error logged successfully";
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}
