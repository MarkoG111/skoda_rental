<?php

namespace app\models\prices;

use app\config\Database;
use PDOException;

class Price
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function insertPrice($car_id, $price_per_day)
  {
    try {
      $query = "INSERT INTO prices (car_id, price_per_day) VALUES (?, ?)";

      $params = [$car_id, $price_per_day];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("insertPrice method error " . $ex->getMessage());
    }
  }
}
