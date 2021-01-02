<?php

namespace app\Models;

use app\Config\Database;

class Bodywork
{
  private $conn;

  public function __construct(Database $conn)
  {
    $this->conn = $conn;
  }

  public function getCarBodyworks($idModel)
  {
    $params = [$idModel];
    $query = "SELECT m.*, i.alt, i.bodyworkPath, b.bodyworkName FROM model m JOIN model_bodywork_image mbi ON m.idModel = mbi.idModel JOIN image i ON mbi.idImage = i.idImage JOIN bodywork b ON mbi.idBodywork = b.idBodywork WHERE mbi.idModel = ?";
    return $this->conn->executeAll($query, $params);
  }
}
// JOIN car c ON mbi.idModelBodyworkImage = c.idModelBodyworkImage JOIN price p ON c.idCar = p.idCar