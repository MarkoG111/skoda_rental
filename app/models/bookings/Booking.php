<?php

namespace app\models\bookings;

use app\config\Database;
use PDOException;

class Booking
{
  private $connection;

  public function __construct(Database $connection)
  {
    $this->connection = $connection;
  }

  public function checkIfAlreadyBooked(int $user_id, int $car_id)
  {
    try {
      $query = "SELECT * FROM bookings WHERE user_id = ? AND car_id = ? AND status = 0";

      $params = [$user_id, $car_id];

      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("checkIfAlreadyBooked method error " . $ex->getMessage());
    }
  }

  public function insertBookingRequest(int $user_id, int $car_id, string $date_from, string $date_to)
  {
    try {
      $query = "INSERT INTO bookings (user_id, car_id, date_from, date_to, status, requested_at) VALUES (?, ?, ?, ?, 0, CURRENT_TIMESTAMP())";

      $params = [$user_id, $car_id, $date_from, $date_to];

      return $this->connection->executeUpsert($query, $params);
    } catch (PDOException $ex) {
      logError("insertBookingRequest method error " . $ex->getMessage());
    }
  }

  public function getAllBookingsUser($user_id)
  {
    try {
      $query = "SELECT b.*, c.name, p.price_per_day, u.first_name, u.last_name, u.email, u.years_of_experience, cat.category_name FROM (SELECT DISTINCT car_id, price_per_day FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN bookings AS b ON c.car_id = b.car_id JOIN categories AS cat ON cat.category_id = c.category_id JOIN users AS u ON b.user_id = u.user_id WHERE u.user_id = ?";

      $params = [$user_id];

      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("getAllBookingsUser method error " . $ex->getMessage());
    }
  }

  public function cancelBooking($booking_id)
  {
    try {
      $query = "UPDATE bookings SET status = 2 WHERE booking_id = ?";

      $params = [$booking_id];

      return $this->connection->executeAll($query, $params);
    } catch (PDOException $ex) {
      logError("cancelBooking method error " . $ex->getMessage());
    }
  }

  public function getAllBookings()
  {
    try {
      $query = "SELECT b.*, c.name, p.price_per_day, u.first_name, u.last_name, u.email, u.years_of_experience, cat.category_name FROM (SELECT DISTINCT car_id, price_per_day FROM prices ORDER BY date DESC) AS p JOIN cars AS c ON p.car_id = c.car_id JOIN bookings AS b ON c.car_id = b.car_id JOIN categories AS cat ON cat.category_id = c.category_id JOIN users AS u ON b.user_id = u.user_id";

      return $this->connection->queryGetAll($query);
    } catch (PDOException $ex) {
      logError("getAllBookings method error " . $ex->getMessage());
    }
  }

  public function confirmBooking($booking_id, $car_id)
  {
    try {
      $query = "SELECT car_id, date_from FROM bookings WHERE booking_id = ?";
      $car = $this->connection->executeOneRow($query, [$booking_id]);

      $car_id = $car->car_id;

      $query_bookings_for_car = "SELECT * FROM bookings WHERE car_id = ? AND status = 1";
      $bookings_for_car = $this->connection->executeAll($query_bookings_for_car, [$car_id]);

      $car->bookings = $bookings_for_car;

      return $car;
    } catch (PDOException $ex) {
      logError("confirmBooking method error " . $ex->getMessage());
    }
  }

  public function acceptBooking($booking_id)
  {
    try {
      $query = "UPDATE bookings SET status = 1 WHERE booking_id = ?";

      return $this->connection->executeAll($query, [$booking_id]);
    } catch (PDOException $ex) {
      logError("acceptBooking method error " . $ex->getMessage());
    }
  }
}
