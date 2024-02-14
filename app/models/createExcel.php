<?php
require_once '../config/config.php';
require_once '../config/Database.php';

$database = \app\config\Database::getInstance();

$query = "SELECT c.name, cat.category_name, c.description FROM cars AS C JOIN categories AS cat ON c.category_id = cat.category_id";
$data = $database->queryGetAll($query);

$output = "";

if (count($data) > 0) {
  $output .= "<table class='excel-table'>
    <thead>
      <tr>
        <td>Car Name</td>
        <td>Category</td>
        <td>Description</td>
      </tr>
    </thead>
    <tbody>";

  foreach ($data as $single) {
    $output .= "<tr>
        <td>" . $single->name . "</td>
        <td>" . $single->category_name . "</td>
        <td>" . $single->description . "</td>
      </tr>";
  }

  $output .= "</tbody>
  </table>";
}

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=cars.xls");

echo $output;
