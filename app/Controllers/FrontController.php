<?php

namespace app\controllers;

use app\config\Database;
use app\models\menu\Menu;
use app\models\cars\Car;
use PDOException;

class FrontController extends BaseController
{
  private function getMenuLinks()
  {
    $database = Database::getInstance();
    $menu_model = new Menu($database);

    $menu_all = $menu_model->getMenuLinks(1);
    $menu_authorized = $menu_model->getMenuLinks(2);
    $menu_admin = $menu_model->getMenuLinks(3);

    return ["menu_all" => $menu_all, "menu_authorized" => $menu_authorized, "menu_admin" => $menu_admin];
  }

  private function getCarDetails($car_id)
  {
    $code = 400;
    $data = null;

    try {
      $database = Database::getInstance();

      $car_model = new Car($database);
      $data = $car_model->getCarDetails($car_id);
      $code = 200;
    } catch (PDOException $ex) {
      logError("Get car details error " . $ex->getMessage());
      $code = 500;
    }

    http_response_code($code);
    return $data;
  }

  public function carDetailsPage()
  {
    $menu_links = $this->getMenuLinks();

    $car_id = $_GET["carId"];
    $car_details = $this->getCarDetails($car_id);

    $this->data = $menu_links;
    $this->data["car_details"] = $car_details;

    $this->loadViewWithoutSlider("carDetails", $this->data);
  }

  public function homePage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadView("home", $menu_links);
  }

  public function carsPage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadView("cars", $menu_links);
  }

  public function aboutPage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadView("about", $menu_links);
  }

  public function contactPage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadViewWithoutSlider("contact", $menu_links);
  }

  public function thanksEmailPage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadViewWithoutSlider("thanksEmail", $menu_links);
  }

  public function adminPage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadView("admin/adminPanel", $menu_links);
  }

  public function userPage()
  {
    $menu_links = $this->getMenuLinks();
    $this->loadView("user/userPanel", $menu_links);
  }
}
