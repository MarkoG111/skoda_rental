<?php

namespace app\models\accounts;

use app\config\Database;
use PDOException;

class Login
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function loginUser(string $email, string $password)
  {
    try {
      $query = "SELECT u.user_id, u.first_name, u.last_name, u.email, r.* FROM users AS u JOIN roles AS r ON u.role_id = r.role_id WHERE u.email = ? AND u.password = MD5(?)";

      $params = [$email, $password];

      return $this->connection->executeOneRow($query, $params);
    } catch (PDOException $ex) {
      logError("loginUser method error " . $ex->getMessage());
    }
  }
}
