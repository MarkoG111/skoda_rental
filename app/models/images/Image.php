<?php

namespace app\models\images;

use app\config\Database;
use PDOException;

class Image
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function insertImages(string $image_name, int $car_id)
  {
    try {
      $query = "INSERT INTO images (image_name, car_id) VALUES (?, ?)";

      $params = [$image_name, $car_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("insertImages method error " . $ex->getMessage());
    }
  }

  public function updateImages(array $new_image_path, int $car_id)
  {
    try {
      $current_images = $this->getImagesByCarId($car_id);

      $existing_images_path = array_column($current_images, 'image_name');

      $images_to_delete = array_diff($existing_images_path, $new_image_path);

      foreach ($images_to_delete as $imagePath) {
        $delete_query = "DELETE FROM images WHERE car_id = ? AND image_name = ?";
        $delete_params = [$car_id, $imagePath];
        $this->connection->executeUpsert($delete_query, $delete_params);
      }

      $images_to_add = array_diff($new_image_path, $existing_images_path);

      foreach ($images_to_add as $new_image_path) {
        $insert_query = "INSERT INTO images (image_name, car_id) VALUES (?, ?)";
        $insert_params = [$new_image_path, $car_id];
        $this->connection->executeUpsert($insert_query, $insert_params);
      }
    } catch (PDOException $ex) {
      logError("updateImages method error " . $ex->getMessage());
    }
  }

  public function getImagesByCarId(int $car_id)
  {
    try {
      $query = "SELECT image_name FROM images WHERE car_id = ?";

      $params = [$car_id];

      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("getImagesByCarId method error " . $ex->getMessage());
      return [];
    }
  }
}
