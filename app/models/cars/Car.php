<?php

namespace app\models\cars;

use app\config\Database;
use PDOException;

class Car
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function insertCar(string $name, string $description, string $main_image, int $model_year, int $mileage, int $seats, int $doors, int $luggage, int $category_id, int $transmission_id, int $fuel_id)
  {
    try {
      $query = "INSERT INTO cars (name, description, main_image, model_year, mileage, seats, doors, luggage, category_id, transmission_id, fuel_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $params = [$name, $description, $main_image, $model_year, $mileage, $seats, $doors, $luggage, $category_id, $transmission_id, $fuel_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("insertCar method error " . $ex->getMessage());
    }
  }

  public function updateCar(string $name, string $description, string $main_image, int $model_year, int $mileage, int $seats, int $doors, int $luggage, int $category_id, int $transmission_id, int $fuel_id, int $car_id)
  {
    try {
      $query = "UPDATE cars SET name = ?, description = ?, main_image = ?, model_year = ?, mileage = ?, seats = ?, doors = ?, luggage = ?, category_id = ?, transmission_id = ?, fuel_id = ? WHERE car_id = ?";

      $params = [$name, $description, $main_image, $model_year, $mileage, $seats, $doors, $luggage, $category_id, $transmission_id, $fuel_id, $car_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("updateCar method error " . $ex->getMessage());
    }
  }

  public function updateCarWithoutImage(string $name, string $description, int $model_year, int $mileage, int $seats, int $doors, int $luggage, int $category_id, int $transmission_id, int $fuel_id, int $car_id)
  {
    try {
      $query = "UPDATE cars SET name = ?, description = ?, model_year = ?, mileage = ?, seats = ?, doors = ?, luggage = ?, category_id = ?, transmission_id = ?, fuel_id = ? WHERE car_id = ?";

      $params = [$name, $description, $model_year, $mileage, $seats, $doors, $luggage, $category_id, $transmission_id, $fuel_id, $car_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("updateCarWithoutImage method error " . $ex->getMessage());
    }
  }

  public function deleteCar(int $car_id)
  {
    try {
      $query = "DELETE FROM cars WHERE car_id = ?";

      $params = [$car_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("deleteCar method error " . $ex->getMessage());
    }
  }

  public function getCars()
  {
    try {
      $query = "SELECT c.*, cat.category_name, f.fuel_type, p.price_per_day, t.transmission_type FROM (SELECT DISTINCT price_id, car_id, price_per_day, date FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN transmissions AS t ON c.transmission_id = t.transmission_id JOIN fuels AS f ON c.fuel_id = f.fuel_id JOIN categories AS cat ON c.category_id = cat.category_id GROUP BY c.car_id";

      return $this->connection->queryGetAll($query);
    } catch (PDOException $ex) {
      logError("getCars method error " . $ex->getMessage());
    }
  }

  public function countCars()
  {
    try {
      $query = "SELECT COUNT(*) AS total FROM cars";

      $number_counter = $this->connection->queryGetOne($query);

      return $number_counter;
    } catch (PDOException $ex) {
      logError("countCars method error " . $ex->getMessage());
    }
  }

  public function getCarsWithPagination()
  {
    try {
      $limit = 3;
      $offset = 0;

      $page_number = 1;

      $cars_count = $this->countCars();
      $total = $cars_count->total;

      $number_of_pages = ceil($total / $limit);

      if ($page_number >= 1) {
        $offset = ($page_number - 1) * $limit;
      }

      $query = "SELECT c.*, cat.category_name, CONCAT(cat.category_name, ' ', c.name) AS car_name, t.transmission_type, f.fuel_type, p.price_per_day FROM (SELECT price_id, car_id, price_per_day, date FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id JOIN fuels AS f ON f.fuel_id = c.fuel_id JOIN transmissions AS t ON c.transmission_id = t.transmission_id WHERE 1 GROUP BY c.car_id LIMIT $limit OFFSET $offset";

      $cars = $this->connection->executeAll($query, []);

      return [
        "cars" => $cars,
        "numberOfPages" => $number_of_pages,
        "currentPage" => $page_number,
        "query" => $query
      ];
    } catch (PDOException $ex) {
      logError("getCarsWithPagination method error " . $ex->getMessage());
    }
  }

  public function filterAndSortCars(string $keyword, string $keyword_nav, int $fuel_id, int $category_id, int $transmission_id, int $min_val_price, int $max_val_price, int $page_number)
  {
    try {
      $limit = 3;
      $offset = 0;

      if (!isset($page_number) || empty($page_number) || $page_number < 1) {
        $page_number = 1;
      }

      $cars_count = $this->countCars();
      $total = $cars_count->total;

      $number_of_pages = ceil($total / $limit);

      if (isset($page_number) && $page_number >= 1) {
        $offset = ($page_number - 1) * $limit;
      }

      $query_string = "";

      $query = "SELECT c.*, cat.category_name, CONCAT(cat.category_name, ' ', c.name) AS car_name, t.transmission_type, f.fuel_type, p.price_per_day FROM (SELECT price_id, car_id, price_per_day, date FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id JOIN fuels AS f ON f.fuel_id = c.fuel_id JOIN transmissions AS t ON c.transmission_id = t.transmission_id WHERE 1";

      if (isset($keyword) && $keyword != "") {
        $query .= " AND LOWER(CONCAT(cat.category_name, ' ', c.name)) LIKE '%$keyword%'";
        $query_string .= "&search-key=$keyword";
      }

      if (isset($keyword_nav) && $keyword_nav != "") {
        $query .= " AND LOWER(CONCAT(cat.category_name, ' ', c.name)) LIKE '%$keyword_nav%'";
        $query_string .= "&search-navigation=$keyword_nav";
      }

      if (isset($fuel_id) && $fuel_id != "0") {
        $query .= " AND c.fuel_id = $fuel_id";
        $query_string .= "&fuel_id=$fuel_id";
      } else {
        $query_string .= "&fuel_id=0";
      }

      if (isset($category_id) && $category_id != "0") {
        $query .= " AND c.category_id = $category_id";
        $query_string .= "&category_id=$category_id";
      } else {
        $query_string .= "&category_id=0";
      }

      if (isset($transmission_id) && $transmission_id != "0") {
        $query .= " AND c.transmission_id = $transmission_id";
        $query_string .= "&transmission_id=$transmission_id";
      } else {
        $query_string .= "&transmission_id=0";
      }

      if (isset($min_val_price) && !empty($min_val_price)) {
        $query .= " AND p.price_per_day >= $min_val_price";
        $query_string .= "&min_val_price=$min_val_price";
      } else {
        $query_string .= "&min_val_price=0";
      }

      if (isset($max_val_price) && !empty($max_val_price)) {
        $query .= " AND p.price_per_day <= $max_val_price";
        $query_string .= "&max_val_price=$max_val_price";
      } else {
        $query_string .= "&max_val_price=0";
      }

      $query .= " AND p.price_id = (SELECT MAX(price_id) FROM prices WHERE car_id = c.car_id)";

      $query_all = $query;

      $result_all = $this->connection->executeAll($query_all, []);

      $total = count($result_all);
      $number_of_pages = ceil($total / $limit);

      $query .= " LIMIT $limit OFFSET $offset";

      $cars = $this->connection->executeAll($query, []);

      return [
        "cars" => $cars,
        "numberOfPages" => $number_of_pages,
        "currentPage" => $page_number,
        "queryString" => $query_string,
        "query" => $query
      ];
    } catch (PDOException $ex) {
      logError("filterAndSortCars method error " . $ex->getMessage());
    }
  }

  public function getCarDetails(int $car_id)
  {
    try {
      $query = "SELECT c.*, cat.category_name, f.fuel_type, p.price_per_day, t.transmission_type FROM (SELECT DISTINCT car_id, price_per_day FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id JOIN fuels AS f ON c.fuel_id = f.fuel_id JOIN transmissions AS t ON c.transmission_id = t.transmission_id WHERE c.car_id = ? LIMIT 1";

      $params = [$car_id];

      $car_details = $this->connection->executeOneRow($query, $params);

      $query_images = "SELECT * FROM images WHERE car_id = ?";
      $images = $this->connection->executeAll($query_images, $params);

      $car_details->images = $images;

      $query_equipment = "SELECT cf.*, f.feature_name FROM car_features AS cf JOIN features AS f ON cf.feature_id = f.feature_id WHERE car_id = ?";
      $equipment = $this->connection->executeAll($query_equipment, $params);

      $car_details->equipment = $equipment;

      $query_reviews = "SELECT r.review_text, u.first_name, u.last_name FROM reviews AS r JOIN users AS u ON r.user_id = u.user_id WHERE review_status = 1 AND car_id = ?";
      $reviews = $this->connection->executeAll($query_reviews, $params);

      $car_details->reviews = $reviews;

      return $car_details;
    } catch (PDOException $ex) {
      logError("getCarDetails method error " . $ex->getMessage());
    }
  }

  public function getSingleCar($car_id)
  {
    try {
      $query_car = "SELECT c.*, cat.category_name, f.fuel_type, p.price_per_day, t.transmission_type FROM (SELECT DISTINCT car_id, price_per_day FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id JOIN fuels AS f ON c.fuel_id = f.fuel_id JOIN transmissions AS t ON c.transmission_id = t.transmission_id WHERE c.car_id = ?";
      $car = $this->connection->executeOneRow($query_car, [$car_id]);

      $query_equipment = "SELECT cf.*, f.feature_name FROM car_features AS cf JOIN features AS f ON cf.feature_id = f.feature_id WHERE car_id = ?";
      $equipment = $this->connection->executeAll($query_equipment, [$car_id]);

      $query_images = "SELECT * FROM images WHERE car_id = ?";
      $images = $this->connection->executeAll($query_images, [$car_id]);

      return ["car" => $car, "equipment" => $equipment, "images" => $images];
    } catch (PDOException $ex) {
      logError("getSingleCar method error " . $ex->getMessage());
    }
  }
}
