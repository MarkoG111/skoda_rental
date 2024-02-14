<?php

namespace app\controllers;

use app\config\Database;
use app\models\accounts\Login;
use PDOException;

class LoginController extends BaseController
{
  public function login($request)
  {
    $data = null;
    $code = 400;

    if (isset($request["email"])) {
      $email = $request["email"];
      $password = $request["password"];

      $regex_password = "/^(?=.*\d).{6,31}$/";

      $errors = [];

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not good.";
      }

      if (!preg_match($regex_password, $password)) {
        $errors[] = "Password is not good.";
      }

      if (count($errors) > 0) {
        $code = 400;
        $data = $errors;
      } else {
        try {
          $password = md5($password);

          $database = Database::getInstance();

          $login_model = new Login($database);

          $data = $login_model->loginUser($email, $password);

          if ($data) {
            $_SESSION["user"] = $data;

            writeUserInFile($data->user_id);

            if ($data->role_id == "1") {
              $this->json("redirect_admin", 200);
              die();
            } else {
              $this->json("redirect_user", 200);
              die();
            }
          } else {
            $this->json("Wrong email or password.", 401);
            die();
          }
        } catch (PDOException $ex) {
          logError("Login user error " . $ex->getMessage());
          $this->json("Error logging in.", 500);
          die();
        }
      }
    }

    $this->json($data, $code);
  }

  public function logout()
  {
    removeUserFromFile($_SESSION["user"]->user_id);

    unset($_SESSION["user"]);
    
    $this->redirect("index.php?page=home");
  }
}
