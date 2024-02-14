<?php

namespace app\controllers;

use app\config\Database;

use app\models\cars\Car;
use app\models\features\CarFeature;
use app\models\images\Image;
use app\models\prices\Price;

use PDOException;

class CarsController extends BaseController
{
  public function insertCar($request)
  {
    $code = 400;
    $data = null;

    if (isset($request["btn-insert-car"])) {
      extract($request);

      $validation_data = new ValidationData();
      $form_elements = $validation_data->getValues($car_name, $category_id, $description, $model_year, $price, $fuel_id, $transmission, $seats, $doors, $mileage, $luggage);
      $equipment = $validation_data->getEquipment();

      $errors = [];

      foreach ($form_elements as $element) {
        if ($element["type"] == "number" || $element["type"] == "ddl") {
          checkNumber($element);
        } else if ($element["type"] == "input") {
          checkInput($element);
        } else if ($element["type"] == "textarea") {
          checkTextarea($element);
        }
      }

      $equipment_values = [];

      foreach ($equipment as $single) {
        if (isset($request[$single["id_prop"]])) {
          $equipment_values[] = 1;
        } else {
          $equipment_values[] = 0;
        }
      }

      $cover_image = $_FILES['main_image'];
      $other_image = $_FILES['other_image'];
      $other_image2 = $_FILES['other_image2'];

      $images_folder = USER_IMAGES;

      $main_image_path = $images_folder . "/" . $cover_image["name"];
      $other_image_path = $images_folder . "/" . $other_image["name"];
      $other_image2_path = $images_folder . "/" . $other_image2["name"];

      $main_image_database_path = "/" . $cover_image["name"];
      $other_image_database_path = "/" . $other_image["name"];
      $other_image2_database_path = "/" . $other_image2["name"];

      $main_image_result = move_uploaded_file($cover_image["tmp_name"], $main_image_path);
      $other_image_result = move_uploaded_file($other_image["tmp_name"], $other_image_path);
      $other_image2_result = move_uploaded_file($other_image2["tmp_name"], $other_image2_path);

      if (count($errors) == 0 || $main_image_result == 1) {
        processImageSize($cover_image, $main_image_path);
        processImageSize($other_image, $other_image_path);
        processImageSize($other_image2, $other_image2_path);

        try {
          $database = Database::getInstance();

          $car_model = new Car($database);
          $car_id = $car_model->insertCar($car_name, $description, $main_image_database_path, $model_year, $mileage, $seats, $doors, $luggage, $category_id, $transmission, $fuel_id);

          $images_for_database = [$other_image_database_path, $other_image2_database_path];
          $images_model = new Image($database);
          foreach ($images_for_database as $key => $image_name) {
            $image_id = $images_model->insertImages($image_name, $car_id);
          }

          $car_features_model = new CarFeature($database);
          $feature_id = 1;
          foreach ($equipment_values as $key => $feature_value) {
            $car_features_id = $car_features_model->insertCarFeatures($feature_id, $car_id, $feature_value);
            $feature_id++;
          }

          $prices_model = new Price($database);
          $price_id = $prices_model->insertPrice($car_id, $price);

          $code = 201;
          $data = true;
        } catch (PDOException $ex) {
          logError("Upload car error" . $ex->getMessage());
          $code = 500;
        }
      } else {
        $code = 400;
        $data = $errors;
      }
    } else {
      $code = 400;
      $data = "Submit form correctly first.";
    }

    echo json_encode(["response" => $data]);
    http_response_code($code);
  }

  public function updateCar($request)
  {
    $code = 400;
    $data = null;

    if (isset($request["btn-update-car"])) {
      extract($request);

      $validation_data = new ValidationData();
      $form_elements = $validation_data->getValues($car_name, $category_id, $description, $model_year, $price, $fuel_id, $transmission, $seats, $doors, $mileage, $luggage);
      $equipment = $validation_data->getEquipment();

      $errors = [];

      foreach ($form_elements as $element) {
        if ($element["type"] == "number" || $element["type"] == "ddl") {
          checkNumber($element);
        } else if ($element["type"] == "input") {
          checkInput($element);
        } else if ($element["type"] == "textarea") {
          checkTextarea($element);
        }
      }

      $equipment_values = [];

      foreach ($equipment as $single) {
        if (isset($request[$single["id_prop"]])) {
          $equipment_values[] = 1;
        } else {
          $equipment_values[] = 0;
        }
      }

      $images_folder = USER_IMAGES;

      if (!file_exists($images_folder)) {
        mkdir($images_folder, 0777, true);
      }

      if (isset($_FILES["main_image"])) {
        $main_image = $_FILES["main_image"];
        $main_image_path = $images_folder . "/" . $main_image["name"];
        $database_path = "/" . $main_image["name"];
        $result = move_uploaded_file($main_image["tmp_name"], $main_image_path);
        processImageSize($_FILES["main_image"], $main_image_path);
      }
      if (isset($_FILES["other_image"])) {
        $other_image = $_FILES["other_image"];
        $other_image_path = $images_folder . "/" . $other_image["name"];
        $other_image_database_path = "/" . $other_image["name"];
        $result = move_uploaded_file($other_image["tmp_name"], $other_image_path);
        processImageSize($_FILES["other_image"], $other_image_path);
      }
      if (isset($_FILES["other_image2"])) {
        $other_image2 = $_FILES["other_image2"];
        $other_image2_path = $images_folder . "/" . $other_image2["name"];
        $other_image2_database_path = "/" . $other_image2["name"];
        $result = move_uploaded_file($other_image2["tmp_name"], $other_image2_path);
        processImageSize($_FILES["other_image2"], $other_image2_path);
      }

      if (count($errors) == 0) {
        try {
          $database = Database::getInstance();

          $car_model = new Car($database);

          if (isset($main_image)) {
            $car_model->updateCar($car_name, $description, $database_path, $model_year, $mileage, $seats, $doors, $luggage, $category_id, $transmission, $fuel_id, $car_id);
          } else {
            $car_model->updateCarWithoutImage($car_name, $description, $model_year, $mileage, $seats, $doors, $luggage, $category_id, $transmission, $fuel_id, $car_id);
          }

          $images_model = new Image($database);
          $images_for_database = [];

          if (isset($other_image_database_path)) {
            $images_for_database[] = $other_image_database_path;
            $images_model->updateImages($images_for_database, $car_id);
          }

          if (isset($other_image2_database_path)) {
            $images_for_database[] = $other_image2_database_path;
            $images_model->updateImages($images_for_database, $car_id);
          }

          $car_features_model = new CarFeature($database);
          $feature_id = 1;

          foreach ($equipment_values as $key => $feature_value) {
            $car_features_model->updateCarFeatures($feature_value, $car_id, $feature_id);
            $feature_id++;
          }

          $prices_model = new Price($database);
          $prices_model->insertPrice($car_id, $price);

          $data = true;
          $code = 200;
        } catch (PDOException $ex) {
          logError("Error updating car " . $ex->getMessage());
          $data = $errors;
          $code = 500;
        }
      }
    } else {
      $code = 400;
      $data = "Submit form correctly first.";
    }

    echo json_encode(["response" => $data]);
    http_response_code($code);
  }

  public function deleteCar($request)
  {
    $code = 400;
    $data = null;

    if (isset($request['btnDeleteCar'])) {
      extract($request);

      try {
        $database = Database::getInstance();

        $car_model = new Car($database);
        $data = $car_model->deleteCar($car_id);
        $code = 200;
      } catch (PDOException $ex) {
        logError("Delete car error " . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }

  public function getAllCars()
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $car_model = new Car($database);
      $data = $car_model->getCars();
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get all cars error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }

  public function filterAndSortCars($request)
  {
    $code = 400;
    $data = null;

    if (isset($request['page_number'])) {
      extract($request);

      try {
        $database = Database::getInstance();

        $car_model = new Car($database);
        $data = $car_model->filterAndSortCars($keyword, $keyword_nav, $fuel_id, $category_id, $transmission_id, $min_val_price, $max_val_price, $page_number);
        $code = 200;
      } catch (PDOException $ex) {
        logError("Filter and sort cars error " . $ex->getMessage());
        $code = 500;
      }
    } else {
      try {
        $database = Database::getInstance();

        $car_model = new Car($database);
        $data = $car_model->getCarsWithPagination();
        $code = 200;
      } catch (PDOException $ex) {
        logError("Filter and sort cars error " . $ex->getMessage());
        $code = 500;
      }
    }

    $this->json($data, $code);
  }

  public function getSingleCar($request)
  {
    $code = 400;
    $data = null;

    try {
      extract($request);

      $database = Database::getInstance();

      $car_model = new Car($database);
      $data = $car_model->getSingleCar($car_id);
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get single car error " . $ex->getMessage());
      $code = 500;
    }

    $this->json($data, $code);
  }
}
