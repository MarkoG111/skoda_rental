<?php

namespace app\controllers;

use app\config\Database;

use app\models\reviews\Review;

use PDOException;

class ReviewsController extends BaseController
{
  public function getAllReviews()
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $review_model = new Review($database);
      $data = $review_model->getAllReviews();
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get all reviews error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function getUserReviews($user_id)
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $review_model = new Review($database);
      $data = $review_model->getUserReviews($user_id);
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get user reviews error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function getCarsForInsertReview($user_id)
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $review_model = new Review($database);
      $data = $review_model->getCarsForInsertReview($user_id);
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get cars for insert reviews error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function insertUserReview($request)
  {
    $code = 400;
    $data = null;

    if (isset($request["btnInsertReview"])) {
      extract($request);

      try {
        $database = Database::getInstance();

        $review_model = new Review($database);
        $data = $review_model->insertUserReview($user_id, $car_id, $review_text);
        $code = 201;
      } catch (PDOException $ex) {
        logError("Insert user review error " . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }

  public function updateUserReview($request)
  {
    $code = 400;
    $data = null;

    if (isset($request["btnUpdateReview"])) {
      extract($request);

      try {
        $database = Database::getInstance();

        $review_model = new Review($database);
        $data = $review_model->updateUserReview($review_text, $review_id);
        $code = 200;
      } catch (PDOException $ex) {
        logError("Update user review error " . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }

  public function deleteUserReview($request)
  {
    $code = 400;
    $data = null;

    if (isset($request["btnDeleteReview"])) {
      extract($request);

      try {
        $database = Database::getInstance();

        $review_model = new Review($database);
        $data = $review_model->deleteUserReview($review_id);
        $code = 200;
      } catch (PDOException $ex) {
        logError("Delete user review error " . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }

  public function changeReviewStatus($request)
  {
    $code = 400;
    $data = null;

    if (isset($request["btnChangeStatus"])) {
      extract($request);

      try {
        $database = Database::getInstance();

        $review_model = new Review($database);
        $data = $review_model->changeReviewStatus($review_status, $review_id);
        $code = 200;
      } catch (PDOException $ex) {
        logError("Change review status error " . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }
}
