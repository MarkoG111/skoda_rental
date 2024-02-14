<?php
require_once "app/config/setup.php";
require_once "app/config/config.php";

use app\controllers\FrontController as FrontController;
use app\controllers\RegisterController as Register;
use app\controllers\LoginController as Login;
use app\controllers\CarsController as Cars;
use app\controllers\BookingController as Booking;
use app\controllers\ReviewsController as Review;

$front_controller = new FrontController();
$cars_controller = new Cars();
$booking_controller = new Booking();
$login_controller = new Login();
$register_controller = new Register();
$review_controller = new Review();

if (isset($_GET["page"])) {
  switch ($_GET["page"]) {
    case "home":
      $front_controller->homePage();
      break;
    case "cars":
      $front_controller->carsPage();
      break;
    case "about":
      $front_controller->aboutPage();
      break;
    case "contact":
      $front_controller->contactPage();
      break;
    case "thanks":
      $front_controller->thanksEmailPage();
      break;
    case "logout":
      $login_controller->logout();
    case "carDetails":
      $front_controller->carDetailsPage();
      break;
    case "admin":
      $front_controller->adminPage();
      break;
    case "user":
      $front_controller->userPage();
      break;
  }
} else if (isset($_GET["ajax"])) {
  switch ($_GET["ajax"]) {
    case "register":
      $register_controller->register($_POST);
      break;
    case "login":
      $login_controller->login($_POST);
      break;
    case "cars":
      $cars_controller->getAllCars();
      break;
    case "insertCar":
      $cars_controller->insertCar($_POST);
      break;
    case "updateCar":
      $cars_controller->updateCar($_POST);
      break;
    case "deleteCar":
      $cars_controller->deleteCar($_POST);
      break;
    case "filterSortCars":
      $cars_controller->filterAndSortCars($_POST);
      break;
    case "singleCar":
      $cars_controller->getSingleCar($_POST);
      break;
    case "adminCars":
      $cars_controller->getAllCars();
      break;
    case "handleBooking":
      $booking_controller->handleBooking($_POST);
      break;
    case "userBookings":
      $user_id = $_SESSION['user']->user_id;
      $booking_controller->getUserBookings($user_id);
      break;
    case "cancelBookingUser":
      $booking_controller->cancelBooking($_POST);
      break;
    case "cancelBookingAdmin":
      $booking_controller->cancelBooking($_POST);
      break;
    case "confirmBooking":
      $booking_controller->confirmBooking($_POST);
      break;
    case "adminBookings":
      $booking_controller->getAllBookings();
      break;
    case "adminReviews":
      $review_controller->getAllReviews();
      break;
    case "userReviews":
      $user_id = $_SESSION['user']->user_id;
      $review_controller->getUserReviews($user_id);
      break;
    case "carsForReview":
      $user_id = $_SESSION['user']->user_id;
      $review_controller->getCarsForInsertReview($user_id);
      break;
    case "insertUserReview":
      $review_controller->insertUserReview($_POST);
      break;
    case "reviewUpdate":
      $review_controller->updateUserReview($_POST);
      break;
    case "reviewDelete":
      $review_controller->deleteUserReview($_POST);
      break;
    case "changeReviewStatus":
      $review_controller->changeReviewStatus($_POST);
      break;
  }
} else {
  $front_controller->homePage();
}
