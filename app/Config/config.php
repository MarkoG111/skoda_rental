<?php

define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"] . "/Skoda_Rent/");

define("ENV_FILE", ABSOLUTE_PATH . "app/config/.env");

define("ERROR_FILE", ABSOLUTE_PATH . "app/data/errors.txt");
define("ACCESS_FILE", ABSOLUTE_PATH . "app/data/access.txt");
define("LOGGED_USERS", ABSOLUTE_PATH . "app/data/loggedUsers.txt");

define("USER_IMAGES", "public/assets/img/uploaded");

define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));

function env($param)
{
  $open = fopen(ENV_FILE, "r");
  $data = file(ENV_FILE);

  $string = "";
  foreach ($data as $key => $value) {
    $config = explode("=", $value);
    if ($config[0] == $param) {
      $string = trim($config[1]);
    }
  }

  fclose($open);

  return $string;
}
