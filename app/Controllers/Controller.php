<?php

namespace app\Controllers;

class Controller
{
  protected $data = null;

  protected function loadView($view, $data = null)
  {
    include "app/Views/Fixed/head.php";
    include "app/Views/Fixed/nav.php";
    include "app/Views/Fixed/slider.php";
    include "app/Views/Pages/{$view}.php";
    include "app/Views/Fixed/footer.php";
  }

  protected function redirect($page)
  {
    header("Location:" . $page);
  }

  protected function json($data = null, $statusCode = 200)
  {
    header("Content-Type: application/json");
    http_response_code($statusCode);
    echo json_encode($data);
  }
}