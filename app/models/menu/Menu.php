<?php

namespace app\models\menu;


use app\config\Database;
use PDOException;


class Menu
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function getMenuLinks($priority)
  {
    try {
      $query = "SELECT * FROM menu WHERE priority = ?";
      $params = [$priority];
      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("getMenuLinks method error " . $ex->getMessage());
    }
  }
}
