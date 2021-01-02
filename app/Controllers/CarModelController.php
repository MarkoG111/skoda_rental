<?php

namespace app\Controllers;

use app\Config\Database;
use app\Models\CarModel;

class CarModelController extends Controller
{
  public function loadModels()
  {
    try {
      $carModelsModel = new CarModel(Database::getInstance());
      $carModels = $carModelsModel->getCarModels();
      $this->json($carModels);
    } catch (\PDOException $ex) {
      $this->json(["error" => $ex->getMessage()], 500);
      logError($ex->getMessage());
    }
  }

  public function getModelsPage()
  {
    $this->loadView("models");
  }
}
