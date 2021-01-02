<?php

namespace app\Models;

use app\Config\Database;

class Person
{
  private $conn;

  public function __construct(Database $conn)
  {
    $this->conn = $conn;
  }

  public function addPerson($firstName, $lastName, $email, $password, $city, $address, $phone, $dateRegistration)
  {
    $params = [$firstName, $lastName, $email, $password, $city, $address, $phone, $dateRegistration];
    $query = "INSERT INTO person VALUES(NULL, ?, ?, ?, MD5(?), ?, ?, ?, ?, 2)";
    $this->conn->executeInsertOrUpdate($query, $params);
  }

  public function getPerson($email, $password)
  {
    $params = [$email, $password];
    $query = "SELECT p.idPerson, p.firstName, p.lastName, p.email, p.city, p.address, p.phone, r.roleName FROM person p JOIN role r ON p.idRole = r.idRole WHERE p.email = ? AND p.password = ?";
    $data = $this->conn->executeAll($query, $params);
    if (!count($data)) {
      return null;
    }
    return $data[0];
  }
}
