<?php

namespace app\Controllers;

use app\Config\Database;
use app\Models\Person;

class RegisterController extends Controller
{
  public function register()
  {
    if (isset($_POST["send"])) {
      $firstName = $_POST["firstName"];
      $lastName = $_POST["lastName"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $confirmPassword = $_POST["confirmPassword"];
      $city = $_POST["city"];
      $address = $_POST["address"];
      $phone = $_POST["phone"];
      $dateRegistration = date("Y-m-d H:i:s", time());

      $errors = [];

      $regexFirstName = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}$/";
      $regexLastName = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{1,25}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,25})*$/";
      $regexPassword = "/^(?=.*\d).{6,31}$/";
      $regexCity = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{1,24}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{1,24})*$/";
      $regexAddress = "/^[A-ZŠĐČĆŽ]?[a-zšđčćž]{1,24}(\s[A-ZŠĐČĆŽ]?[a-zšđčćž]{1,24})*(\s(\d{1,3}.?\d{0,3}))*$/";
      $regexPhone = "/^06[0-79]\/[0-9]{3}\-[0-9]{3,4}$/";

      if (!preg_match($regexFirstName, $firstName)) {
        $errors[] = "First Name must start with uperrcase, 2-26 letters";
      }
      if (!preg_match($regexLastName, $lastName)) {
        $errors[] = "Last Name must start with uperrcase, 2-26 letters";
      }
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not in good format.";
      }
      if (!preg_match($regexPassword, $password)) {
        $errors[] = "Password must have at least 6 characters including number.";
      }
      if ($password !== $confirmPassword) {
        $errors[] = "Passwords must match.";
      }
      if (!preg_match($regexCity, $city)) {
        $errors[] = "City name must start uppercase, 2-25 letters.";
      }
      if (!preg_match($regexAddress, $address)) {
        $errors[] = "Address name is not valid.";
      }
      if (!preg_match($regexPhone, $phone)) {
        $errors[] = "Wrong phone format, sorry.";
      }

      if (count($errors) > 0) {
        $this->json($errors, 422);
        exit;
      } else {
        try {
          $registerModel = new Person(Database::getInstance());
          $registerModel->addPerson($firstName, $lastName, $email, $password, $city, $address, $phone, $dateRegistration);
          $this->json(["message" => "Successfully Registered."], 201);
        } catch (\PDOException $ex) {
          logError($ex->getMessage());
          $this->json(["error" => "Something is wrong, check parameters."], 409);
        }
      }
    } else {
      $this->json(null, 403);
    }
  }
}
