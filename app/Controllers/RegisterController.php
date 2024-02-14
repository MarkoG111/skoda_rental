<?php

namespace app\controllers;

use app\config\Database;
use app\models\accounts\Register;
use PDOException;

class RegisterController extends BaseController
{
  public function register($request)
  {
    $data = null;
    $code = 400;

    if (isset($request["send"])) {
      $first_name = $request["first_name"];
      $last_name = $request["last_name"];
      $email = $request["email"];
      $password = $request["password"];
      $city = $request["city"];
      $address = $request["address"];
      $phone = $request["phone"];
      $licence_number = $request["licence_number"];
      $years_of_experience = $request["years_of_experience"];

      $regex_first_name = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}$/";
      $regex_last_name = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,25})*$/";
      $regex_password = "/^(?=.*\d).{6,31}$/";
      $regex_city = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{1,24}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,24})*$/";
      $regex_address = "/^[A-ZŠĐČĆŽ]?[a-zšđčćž]{1,24}(\s[A-ZŠĐČĆŽ]?[a-zšđčćž]{1,24})*(\s(\d{1,3}.?\d{0,3}))*$/";
      $regex_phone = "/^06[0-79]\/[0-9]{3}\-[0-9]{3,4}$/";
      $regex_licence_number = "/^[A-Z\d]{1,5}-\d{3}-\d{2}-\d{3}-\d$/";
      $regex_experience_years = "/^(?:[0-9]|[1-6][0-9]|70)$/";

      $errors = [];

      if (!preg_match($regex_first_name, $first_name)) {
        array_push($errors, "Fist Name field isn't proprely filled!");
      } elseif (!$first_name) {
        array_push($errors, "First Name is required!");
      }

      if (!preg_match($regex_last_name, $last_name)) {
        array_push($errors, "Last Name field isn't proprely filled!");
      } elseif (!$last_name) {
        array_push($errors, "Last Name is required!");
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email isn't in good format!");
      }

      if (!preg_match($regex_password, $password)) {
        array_push($errors, "Password field isn't proprely filled!");
      } elseif (!$password) {
        array_push($errors, "Password is required!");
      }

      if (!preg_match($regex_city, $city)) {
        array_push($errors, "City field isn't proprely filled!");
      } elseif (!$city) {
        array_push($errors, "City is required!");
      }

      if (!preg_match($regex_address, $address)) {
        array_push($errors, "Address field isn't proprely filled!");
      } elseif (!$address) {
        array_push($errors, "Address is required!");
      }

      if (!preg_match($regex_phone, $phone)) {
        array_push($errors, "Phone field isn't proprely filled!");
      } elseif (!$phone) {
        array_push($errors, "Phone is required!");
      }

      if (!preg_match($regex_licence_number, $licence_number)) {
        array_push($errors, "Licence number isn't proprely filled!");
      } elseif (!$licence_number) {
        array_push($errors, "Licence number is required!");
      }

      if (!preg_match($regex_experience_years, $years_of_experience)) {
        array_push($errors, "Experience years isn't proprely filled!");
      } elseif (!$years_of_experience) {
        array_push($errors, "Experience years is required!");
      }

      if (count($errors)) {
        $code = 422;
        $data = $errors;
      } else {
        try {
          $database = Database::getInstance();
          $register_model = new Register($database);

          $data = $register_model->registerUser($first_name, $last_name, $email, $password, $city, $address, $phone, $licence_number, $years_of_experience, 2);

          $code = $data ? 201 : 500;
        } catch (PDOException $ex) {
          logError("Registration user error " . $ex->getMessage());
          $code = 409;
        }
      }
    }

    $this->json($data, $code);
  }
}
