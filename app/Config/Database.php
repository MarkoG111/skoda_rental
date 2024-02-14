<?php

namespace app\config;

use PDOException;

class Database
{
  private $connection;
  private static $instance;

  private function __construct()
  {
  }

  public static function getInstance(\PDO $connection = null)
  {
    if (self::$instance == null) {
      self::$instance = new Database();

      if ($connection != null) {
        self::$instance->connection = $connection;
      } else {
        self::$instance->getConnection();
      }
    }

    return self::$instance;
  }

  private function getConnection()
  {
    try {
      $this->connection = new \PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USERNAME, PASSWORD);
      $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
      $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
      logError("Error with database connection: " . $ex->getMessage());
    }
  }

  public function queryGetAll(string $query)
  {
    return $this->connection->query($query)->fetchAll();
  }

  public function queryGetOne(string $query)
  {
    return $this->connection->query($query)->fetch();
  }

  public function executeOneRow(string $query, array $params)
  {
    $prepare = $this->connection->prepare($query);
    $prepare->execute($params);

    return $prepare->fetch();
  }

  public function executeAll(string $query, array $params)
  {
    $prepare = $this->connection->prepare($query);
    $prepare->execute($params);

    return $prepare->fetchAll();
  }

  public function executeUpsert(string $query, array $params)
  {
    $prepare = $this->connection->prepare($query);
    $prepare->execute($params);

    return $prepare->rowCount() > 0 ? $this->connection->lastInsertId() : false;
  }
}
