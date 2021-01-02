<?php

require_once "app/Config/setup.php";
require_once "app/Config/config.php";

use app\Controllers\HomeController as Home;
use app\Controllers\CarModelController as CarModel;
use app\Controllers\RegisterController as Register;
use app\Controllers\LoginController as Login;
use app\Controllers\BodyworkController as Bodywork;

$homeController = new Home();
$carModelsController = new CarModel();
$registerController = new Register();
$loginController = new Login();
$bodyworksController = new Bodywork();

if (isset($_GET["page"])) {
  switch ($_GET["page"]) {
    case "home":
      $homeController->getHomePage();
      break;
    case "models":
      $carModelsController->getModelsPage();
      break;
    case "loadModels":
      $carModelsController->loadModels();
      break;
    case "doRegister":
      $registerController->register();
      break;
    case "doLogin":
      $loginController->login($_POST);
      break;
    case "logout":
      $loginController->logout();
      break;
    case "bodyworks":
      $bodyworksController->getCarBodyworks($_GET);
      break;
    default:
      $homeController->getHomePage();
      break;
  }
} else {
  $homeController->getHomePage();
}
