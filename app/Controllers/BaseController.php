<?php

namespace app\controllers;

class BaseController
{
  protected $data = null;

  protected function loadView($view, $data = null)
  {
    require_once "app/views/fixed/head.php";
    require_once "app/views/fixed/nav.php";
    require_once "app/views/fixed/slider.php";
    require_once "app/views/pages/{$view}.php";
    require_once "app/views/fixed/footer.php";
    require_once "app/views/fixed/modals.php";
  }

  protected function loadViewWithoutSlider($view, $data = null)
  {
    require_once "app/views/fixed/head.php";
    require_once "app/views/fixed/nav.php";
    require_once "app/views/pages/{$view}.php";
    require_once "app/views/fixed/footer.php";
    require_once "app/views/fixed/modals.php";
  }

  protected function redirect($page)
  {
    header("Location:" . $page);
  }

  protected function json($data = null, $status_code = 200)
  {
    header("Content-Type: application/json");
    http_response_code($status_code);
    echo json_encode($data);
  }
}
