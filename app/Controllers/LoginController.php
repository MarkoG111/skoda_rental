<?php
namespace app\Controllers;

use app\Config\Database;
use app\Models\Person;

class LoginController extends Controller
{
  public function login($request)
  {
    if (isset($request['btnLogin'])) {
      $email = $request['tbEmail'];
      $password = $request['tbPassword'];

      $regexPassword = "/^(?=.*\d).{6,31}$/";

      $errors = [];

      if (!preg_match($regexPassword, $password)) {
        $errors[] = "Password is not in good format.";
      }
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not in good format.";
      }

      if (count($errors)) {
        $_SESSION["login-errors"] = $errors;
        $this->redirect("index.php?page=home");
        exit;
      } else {
        $loginModel = new Person(Database::getInstance());

        try {
          $password = md5($password);
          $person = $loginModel->getPerson($email, $password);
          if ($person == null) {
            $_SESSION["login-errors"] = ["Email or Password is not correct."];
            $this->redirect("index.php?page=home");
            exit;
          } else {
            $_SESSION['person'] = $person;
            $this->redirect("index.php?page=home");
          }
        } catch (\PDOException $ex) {
          logError($ex->getMessage());
        }
      }
    } else {
      $_SESSION["login-errors"] = ["No action provided."];
      $this->redirect("index.php?page=home");
    };
  }

  public function logout()
  {
    unset($_SESSION['person']);
    $this->redirect("index.php?page=home");
  }
}
