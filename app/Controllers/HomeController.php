<?php

namespace app\Controllers;

class HomeController extends Controller
{
  public function getHomePage()
  {
    $this->loadView("home");
  }
}
