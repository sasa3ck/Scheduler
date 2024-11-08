<?php

require './config/DataBaseInterface.php';

class Database implements DataBaseInterface
{
  private \PDO $pdo;
  private array $config;

  public function __construct(array $config = [])
  {
    $this->config = !empty($config) ? $config : $this->getDefaultConfig();
    $this->connect();
  }

  private function getDefaultConfig(): array
  {
    return [
      'driver' => 'mysql',
      'host' => 'database',
      'port' => '3306',
      'database' => 'lamp',
      'username' => 'lamp',
      'password' => 'lamp',
      'charset' => 'utf8',
    ];
  }

  private function connect(): void
  {
    $config = $this->config;

    $driver = $config['driver'];
    $host = $config['host'];
    $port = $config['port'];
    $database = $config['database'];
    $username = $config['username'];
    $password = $config['password'];
    $charset = $config['charset'];

    try {
      $this->pdo = new \PDO(
        "$driver:host=$host;port=$port;dbname=$database;charset=$charset",
        $username,
        $password
      );
    } catch (\PDOException $exception) {
      exit("Database exception failed: {$exception->getMessage()}");
    }
  }

  public function getPdo(): \PDO
  {
    return $this->pdo;
  }
}
