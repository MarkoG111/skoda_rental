<?php

session_start();

function autoload($class_name)
{
  $class_name = ltrim($class_name, '\\');
  $file_name = '';
  $namespace = '';

  if ($last_pos = strrpos($class_name, '\\')) {
    $namespace = substr($class_name, 0, $last_pos);
    $class_name = substr($class_name, $last_pos + 1);
    $file_name = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
  }

  $file_name .= str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

  if (file_exists($file_name)) {
    require_once $file_name;
  } else {
    echo "File not found: $file_name";
  }
}

spl_autoload_register('autoload');


function printTitle()
{
  $url = explode("?", $_SERVER["REQUEST_URI"]);

  if (count($url) == 1) {
    echo "<title>Škoda - Home</title>";
  }

  if (isset($url[1])) {
    $params = explode("&", $url[1]);

    switch ($params[0]) {
      case "page=home":
        echo "<title>Škoda - Home</title>";
        break;
      case "page=cars":
        echo "<title>Škoda - Cars</title>";
        break;
      case "page=carDetails":
        $car_id = "";
        if (count($params) > 1) {
          $car_id = substr($params[1], 6);
        }
        if ($car_id != "") {
          echo "<title>Škoda - Car Details - Car ID: $car_id</title>";
        } else {
          echo "<title>Škoda - Car Details</title>";
        }
        break;
      case "page=about":
        echo "<title>Škoda - About</title>";
        break;
      case "page=contact":
        echo "<title>Škoda - Contact</title>";
        break;
      case "page=admin":
        echo "<title>Škoda - Admin</title>";
        break;
      case "page=user":
        echo "<title>Škoda - User</title>";
        break;
    }
  }
}

function printDescription()
{
  $url = explode("?", $_SERVER["REQUEST_URI"]);

  if (count($url) == 1) {
    $contet = "We are agency for rent a car. Here you can find best deals";
  }

  if (isset($url[1])) {
    $params = explode("&", $url[1]);

    switch ($params[0]) {
      case "page=home":
        $contet = "We are agency for rent a car. Here you can find best deals";
        break;
      case "page=cars":
        $contet = "Here you can see our rich offer of luxury and afordable cars (based on your budget)";
        break;
      case "page=carDetails":
        $car_id = "";
        if (count($params) > 1) {
          $car_id = substr($params[1], 6);
        }
        if ($car_id != "") {
          $contet = "Find more information about single car, ID: " . $car_id;
        } else {
          $contet = "Find more information about single car";
        }
        break;
      case "page=about":
        $contet = "Find more information about Skoda Rent";
        break;
      case "page=contact":
        $contet = "Contact us for any question you have and maybe negotiate about price";
        break;
      case "page=admin":
        $contet = "Admin panel of Skoda Rent website";
        break;
      case "page=user":
        $contet = "User profie";
        break;
    }
  }

  echo "<meta name=\"description\" content=\"{$contet}\" />";
}

function printFormInput($id_attr, $text, $input_type)
{
  $output = "
    <div class='form-group'>
        <label for='$id_attr'>$text</label>
        <input type='" . $input_type . "' class='form-control' name='$id_attr' id='$id_attr' />

        <small id='" . $id_attr . "Err' class='form-text text-danger error-field'>Valid format: </small>
    </div>
  ";

  echo $output;
}

function printFormList($data, $id_prop, $value_prop, $text)
{
  $output = "
    <div class='form-group'>
      <label for=''>$text</label>
      <select class='form-control' name='$value_prop' id='$id_prop'>
        <option value='0'>Select</option>";
  $output .= fillLists($data, $id_prop, $value_prop);
  $output .= "
      </select>
    </div>
  ";

  echo $output;
}

function fillLists($data, $id_prop, $value_prop)
{
  $output = "";

  for ($i = 0; $i < count($data); $i++) {
    $output .= "<option value='" . $data[$i][$id_prop] . "'>" . $data[$i][$value_prop] . "</option>";
  }

  return $output;
}

function printCheckbox($data, $id_prop, $value_prop, $text)
{
  $output = "<div class='form-group'>
    <p>$text</p>
  </div>";

  for ($i = 0; $i < count($data); $i++) {
    $output .= "<div class='custom-control custom-radio'>
      <input type='radio' class='custom-control-input' id='custom-radio-$i' name='" . strtolower($text) . "' value='" . $data[$i][$id_prop] . "'/>
      <label class='custom-control-label' for='custom-radio-$i'>" . $data[$i][$value_prop] . "</label>
    </div>";
  }

  $output .= "<small id='transmission_type_err' style='display:none;' class='form-text text-danger error-field'>Select one option</small>";

  echo $output;
}

function printImageFile($id_prop, $text_prop)
{
  $output = "<label for='$id_prop'>$text_prop</label>
  <input type='file' class='form-control' name='$id_prop' id='$id_prop' />
  <small id='" . $id_prop . "Err' class='form-text text-danger error-field'>Attach photo</small>";

  echo $output;
}

function printEquipment($accessories_database = null)
{
  $accessories = [
    [
      "id_prop" => "aircondition",
      "text" => "Airconditions"
    ],
    [
      "id_prop" => "break_system",
      "text" => "AntiLock Breaking System"
    ],
    [
      "id_prop" => "leather_seats",
      "text" => "Leather Seats"
    ],
    [
      "id_prop" => "brake_assist",
      "text" => "Brake Assist"
    ],
    [
      "id_prop" => "crash_sensor",
      "text" => "Crash Sensor"
    ],
    [
      "id_prop" => "onboard_pc",
      "text" => "Onboard computer"
    ],
    [
      "id_prop" => "gps",
      "text" => "GPS"
    ],
    [
      "id_prop" => "locking",
      "text" => "Central Locking"
    ],
    [
      "id_prop" => "abs",
      "text" => "ABS"
    ],
    [
      "id_prop" => "bluetooth",
      "text" => "Bluetooth"
    ],
    [
      "id_prop" => "child_seat",
      "text" => "Child Seat"
    ],
    [
      "id_prop" => "parking_sensor",
      "text" => "Parking Sensors"
    ],
  ];

  $output = "";

  for ($i = 0; $i < count($accessories); $i++) {
    if (isset($accessories_database) && $accessories_database[$i]["feature_value"] == 1) {
      $checked = "checked='checked'";
    } else {
      $checked = "";
    }

    $output .= "
    <div class='col-md-4 my-2'>
      <div class='form-check form-check-inline'>
        <input class='accessories form-check-input' type='checkbox' id='" . $accessories[$i]['id_prop'] . "' name='" . $accessories[$i]['id_prop'] . "' value='1' $checked />
        <label class='form-check-label' for='" . $accessories[$i]['id_prop'] . "'>" . $accessories[$i]['text'] . "</label>
      </div>
    </div>";
  }

  echo $output;
}

function printEquipmentAddons($data)
{
  $output = "";

  foreach ($data as $key => $single) {
    $class_icon = "";

    if ($single->feature_value == 1) {
      $class_icon = "fi fi-br-check";
    } else {
      $class_icon = "fi fi-br-cross";
    }

    $output .= "
    <li class='check'><span class='$class_icon'></span>" . $single->feature_name . "</li>";
  }

  echo $output;
}

function checkInput($element)
{
  global $errors;

  if (!preg_match($element["regex"], $element["value"])) {
    $errors[] = "Valid format: " + $element["example"];
  }
}

function checkNumber($element)
{
  global $errors;

  if ($element["type"] == "ddl" || $element["type"] == "number") {
    if (!isset($element["value"]) || $element["value"] < 1) {
      $errors[] = $element["error"];
    } else {
      if (!isset($element["value"]) || strlen($element["value"]) < 10) {
        $errors[] = $element["value"];
      }
    }
  }
}

function checkTextarea($element)
{
  global $errors;

  if (!isset($element["value"]) || strlen($element["value"]) < 10) {
    $errors[] = $element["error"];
  }
}

function processImageSize($file, $new_path)
{
  list($width, $height) = getimagesize($new_path);

  $new_width_big = 720;
  $new_width_small = 200;

  $percent_change = $new_width_big / $width;
  $new_height = $height * $percent_change;

  $new_image = imagecreatetruecolor($new_width_big, $new_height);

  $create = "";
  if ($file["type"] == "image/jpeg") {
    $create = imagecreatefromjpeg($new_path);
  } elseif ($file["type"] == "image/png") {
    $create = imagecreatefrompng($new_path);
    if ($create === false) {
      die('Cannot create resource from png.');
    }
  } else {
    die('Invalid image format.');
  }

  imagecopyresampled($new_image, $create, 0, 0, 0, 0, $new_width_big, $new_height, $width, $height);

  imagejpeg($new_image, $new_path);

  // small image
  $percent_change_small = $new_width_small / $width;
  $new_height_small = $height * $percent_change_small;

  $new_image_small = imagecreatetruecolor($new_width_small, $new_height_small);

  imagecopyresampled($new_image_small, $create, 0, 0, 0, 0, $new_width_small, $new_height_small, $width, $height);

  $name_array = explode(".", $new_path);
  $name_array[0] .= "-small";

  $new_image_name = implode(".", $name_array);

  imagejpeg($new_image_small, $new_image_name);
}

function logError($error)
{
  @$open = fopen(ERROR_FILE, "a");

  $print = $error . "\t" . date("d-m-Y H:i:s") . "\n";

  @fwrite($open, $print);
  @fclose($open);
}

function logAccess()
{
  @$open = fopen(ACCESS_FILE, "a");

  if ($open) {
    @fwrite($open, $_SERVER['REQUEST_URI'] . "\t" . date('d-m-Y H:i:s') . "\t" . $_SERVER['REMOTE_ADDR'] . "\t \n");
    @fclose($open);
  }
}

function writeUserInFile($user_id)
{
  $file = fopen(LOGGED_USERS, "a");

  if ($file) {
    $str = "$user_id\n";

    fwrite($file, $str);
    fclose($file);
  }
}

function removeUserFromFile($user_id)
{
  $array = file(LOGGED_USERS);

  $new_string = "";

  foreach ($array as $uid) {
    $uid = trim($uid);

    if ($uid != $user_id) {
      $new_string .= $uid . "\n";
    }
  }

  $file = fopen(LOGGED_USERS, "w");

  fwrite($file, $new_string);
  fclose($file);
}
