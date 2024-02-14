<?php

namespace app\models\reviews;

use app\config\Database;
use PDOException;

class Review
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function getAllReviews()
  {
    try {
      $query = "SELECT r.*, u.first_name, u.last_name, c.name, cat.category_name FROM reviews AS r JOIN users AS u ON r.user_id = u.user_id JOIN cars AS c ON r.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id";

      return $this->connection->queryGetAll($query);
    } catch (PDOException $ex) {
      logError("getAllReviews method error " . $ex->getMessage());
    }
  }

  public function getUserReviews($user_id)
  {
    try {
      $query = "SELECT r.*, c.name, cat.category_name FROM reviews AS r JOIN cars AS c ON r.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id WHERE user_id = ?";

      $params = [$user_id];

      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("getUserReviews method error " . $ex->getMessage());
    }
  }


  public function getCarsForInsertReview($user_id)
  {
    try {
      $query = "SELECT b.car_id, c.name, cat.category_name FROM bookings AS b JOIN cars AS c ON b.car_id = c.car_id JOIN categories AS cat ON c.category_id = cat.category_id WHERE user_id = ? AND status = 1 AND b.car_id NOT IN (SELECT car_id FROM reviews WHERE user_id = ?)";

      $params = [$user_id, $user_id];

      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("getCarsForInsertReview method error " . $ex->getMessage());
    }
  }

  public function insertUserReview($user_id, $car_id, $review_text)
  {
    try {
      $query = "INSERT INTO reviews (user_id, car_id, review_text, review_status) VALUES (?, ?, ?, 0)";

      $params = [$user_id, $car_id, $review_text];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("insertUserReview method error " . $ex->getMessage());
    }
  }

  public function updateUserReview($review_text, $review_id)
  {
    try {
      $query = "UPDATE reviews SET review_text = ? WHERE review_id = ?";

      $params = [$review_text, $review_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("updateUserReview method error " . $ex->getMessage());
    }
  }

  public function deleteUserReview($review_id)
  {
    try {
      $query = "DELETE FROM reviews WHERE review_id = ?";

      $params = [$review_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("deleteUserReview method error " . $ex->getMessage());
    }
  }

  public function changeReviewStatus($review_status, $review_id)
  {
    try {
      $query = "UPDATE reviews SET review_status = ? WHERE review_id = ?";

      $params = [$review_status, $review_id];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("changeReviewStatus method error " . $ex->getMessage());
    }
  }
}
