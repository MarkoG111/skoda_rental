<?php

namespace app\models\features;

use app\config\Database;
use PDOException;

class CarFeature
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function insertCarFeatures($feature_id, $car_id, $feature_value)
  {
    try {
      $query = "INSERT INTO car_features (feature_id, car_id, feature_value) VALUES (?, ?, ?)";

      $params = [$feature_id, $car_id, $feature_value];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("insertCarFeatures method error " . $ex->getMessage());
    }
  }

  public function updateCarFeatures($feature_value, $car_id, $feature_id)
  {
    try {
      $query = "UPDATE car_features SET feature_value = ? WHERE car_id = ? AND feature_id = ?";

      $params = [$feature_value, $car_id, $feature_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("updateCarFeatures method error " . $ex->getMessage());
    }
  }
}
