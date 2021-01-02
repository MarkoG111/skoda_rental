<?php

namespace app\Models;

use app\Config\Database;

class CarModel
{
  private $conn;

  public function __construct(Database $conn)
  {
    $this->conn = $conn;
  }

  public function getCarModels()
  {
    $query = "SELECT m.*, i.alt, i.path FROM model m JOIN model_bodywork_image mbi ON m.idModel = mbi.idModel JOIN image i ON mbi.idImage = i.idImage WHERE i.path IS NOT NULL";
    return $this->conn->queryGetAll($query);
  }
}