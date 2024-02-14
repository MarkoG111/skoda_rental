<?php

namespace app\models\accounts;

use app\config\Database;
use PDOException;

class Register
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function registerUser(string $first_name, string $last_name, string $email, string $password, string $city, string $address, string $phone, string $licence_number, int $years_of_experience, int $role_id)
  {
    try {
      $hashed_password = md5($password);

      $query = "INSERT INTO users (first_name, last_name, email, password, city, address, phone, licence_number, years_of_experience, role_id) VALUES (?, ?, ?, MD5(?), ?, ?, ?, ?, ?, ?)";

      $params = [$first_name, $last_name, $email, $hashed_password, $city, $address, $phone, $licence_number, $years_of_experience, $role_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("registerUser method error " . $ex->getMessage());
    }
  }
}
