<?php

namespace app\controllers;

class ValidationData
{
  public static function getValues($car_name, $category_id, $description, $model_year, $price, $fuel_id, $transmission, $seats, $doors, $mileage, $luggage)
  {
    return [
      [
        "type" => "input",
        "value" => $car_name,
        "regex" => "/^[A-z\s\d\.]{2,30}$/",
        "example" => "Sportage"
      ],
      [
        "type" => "ddl",
        "value" => $category_id,
        "error" => "Select category"
      ],
      [
        "type" => "textarea",
        "value" => $description,
        "error" => "Description must have at least 10 characters"
      ],
      [
        "type" => "text",
        "value" => $model_year,
        "regex" => "/^(19|20)[0-9]{2}$/",
        "example" => "2000"
      ],
      [
        "type" => "number",
        "value" => $price,
        "error" => "Enter positive number between 10 and 500"
      ],
      [
        "type" => "ddl",
        "value" => $fuel_id,
        "error" => "Select fuel type"
      ],
      [
        "type" => "ddl",
        "value" => $transmission,
        "error" => "Select transmission type"
      ],
      [
        "type" => "number",
        "value" => $seats,
        "error" => "Enter positive number"
      ],
      [
        "type" => "number",
        "value" => $doors,
        "error" => "Enter positive number"
      ],
      [
        "type" => "number",
        "value" => $mileage,
        "error" => "Enter positive number"
      ],
      [
        "type" => "number",
        "value" => $luggage,
        "error" => "Enter positive number"
      ],
    ];
  }

  public static function getEquipment()
  {
    return [
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
  }
}
