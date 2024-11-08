<?php

function sendEmailNotification(string $email, string $message): void
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format: $email<br>";
    return;
  }

  $subject = "Уведомление о выполнении задачи";
  $headers = "From: no-reply@example.com\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  $mail_success = mail($email, $subject, $message, $headers);
  if ($mail_success) {
    echo "Email sent successfully to $email<br>";
  } else {
    echo "Failed to send email to $email<br>";
  }
}

function sendEmailNotificationExample(): void
{
  $email = 'example@example.com';
  $message = 'The task was completed successfully';

  sendEmailNotification($email, $message);
}
