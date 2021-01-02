<?php

namespace app\Config;

class Database
{
  private $conn;
  private static $instance;

  public function __construct()
  {
    $this->getConnection();
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    try {
      $this->conn = new \PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USERNAME, PASSWORD);
      $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
      $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $ex) {
      logError("Error with db connection: " . $ex->getMessage());
    }
  }

  public function queryGetAll(string $query)
  {
    return $this->conn->query($query)->fetchAll();
  }

  public function queryGetOne(string $query)
  {
    return $this->conn->query($query)->fetch();
  }

  public function executeOneRow(string $query, array $params)
  {
    $prepare = $this->conn->prepare($query);
    $prepare->execute($params);
    return $prepare->fetch();
  }

  public function executeAll(string $query, array $params)
  {
    $prepare = $this->conn->prepare($query);
    $prepare->execute($params);
    return $prepare->fetchAll();
  }

  public function executeInsertOrUpdate(string $query, Array $params)
  {
    $prepare = $this->conn->prepare($query);
    $prepare->execute($params);
  }
}
