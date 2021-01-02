<?php

namespace app\Controllers;

use app\Config\Database;
use app\Models\Bodywork;

class BodyworkController extends Controller
{
  public function getCarBodyworks($request)
  {
    if (isset($request["idModel"])) {
      $idModel = $request["idModel"];

      $bodyworksModel = new Bodywork(Database::getInstance());

      $bodyworks = $bodyworksModel->getCarBodyworks($idModel);

      if ($bodyworks == null) {
        $this->redirect("index.php?page=home"); // 404 treba
      }

      $this->data["bodyworks"] = $bodyworks;

      $this->loadView("bodyworks", $this->data);
    } else {
      $this->redirect("index.php?page=home"); // 400 treba
    }
  }
}
