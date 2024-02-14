<?php

namespace app\controllers;

use app\config\Database;
use app\models\bookings\Booking;
use PDOException;

class BookingController extends BaseController
{
  public function handleBooking($request)
  {
    $code = 400;
    $data = null;

    extract($request);

    if ($btn_send_request) {
      try {
        $database = Database::getInstance();

        $booking_model = new Booking($database);

        $check_bookings = $booking_model->checkIfAlreadyBooked($user_id, $car_id);
        $is_checked = false;

        foreach ($check_bookings as $key => $single) {
          if ($date_from <= $single->date_to) {
            $is_checked = true;
            $data = "You already submitted request to this car";
            break;
          }
        }

        if ($is_checked == false) {
          $booking_id = $booking_model->insertBookingRequest($user_id, $car_id, $date_from, $date_to);
          $data = "You successfully requested. Wait for admin's approval";
          $code = 201;
        }
      } catch (PDOException $ex) {
        logError("Handle booking error" . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }

  public function getUserBookings($user_id)
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $booking_model = new Booking($database);
      $data = $booking_model->getAllBookingsUser($user_id);
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get user bookings error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function cancelBooking($request)
  {
    $code = 400;
    $data = null;

    try {
      extract($request);

      $database = Database::getInstance();

      $booking_model = new Booking($database);
      $data = $booking_model->cancelBooking($booking_id);
      $code = 200;
    } catch (PDOException $ex) {
      logError("Cancel user booking error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function getAllBookings()
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $booking_model = new Booking($database);
      $data = $booking_model->getAllBookings();
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get bookings error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function confirmBooking($request)
  {
    $code = 400;
    $data = null;

    extract($request);

    if ($btn_handle_book) {
      try {
        $database = Database::getInstance();

        $booking_model = new Booking($database);
        $data = $booking_model->confirmBooking($booking_id, $car_id);

        $avail = true;

        foreach ($data->bookings as $key => $booking) {
          if ($data->date_from < $booking->date_to) {
            $avail = false;
            $message = "Car is already rented";
            break;
          }
        }

        if ($avail) {
          $message = "Car is available for rent";

          try {
            $booking_model->acceptBooking($booking_id);
            $avail = true;
            $message = "Successfully approved";
            $code = 200;
          } catch (PDOException $ex) {
            logError("Accept booking error " . $ex->getMessage());
            $avail = false;
            $message = "Select valid booking item";
            $code = 500;
          }
        }
      } catch (PDOException $ex) {
        logError("Confirm bookings error " . $ex->getMessage());
        $code = 500;
      }
    } else {
      $code = 400;
      $message = "Submit confirmation";
    }

    echo json_encode($message);
    http_response_code($code);
  }
}
