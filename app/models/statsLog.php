<?php
require_once '../../../config/config.php';

$open = fopen(ACCESS_FILE, "r");

if ($open) {
  $data = file(ACCESS_FILE);
  fclose($open);

  $n = count($data);

  define("DAY_SECONDS", 24 * 60 * 60);

  $log_last_day = [];

  for ($i = 0; $i < $n; $i++) {
    $row = explode("\t", $data[$i]);
    $t = $row[1];
    $before_24h = time() - DAY_SECONDS;
    $utt = strtotime($t);
    if ($utt >= $before_24h) {
      $log_last_day[] = $row[0];
    }
  }

  $n = count($log_last_day);
  $log_last_day_distinct = [];
  for ($i = 0; $i < $n; $i++) {
    if (!in_array($log_last_day[$i], $log_last_day_distinct)) {
      $log_last_day_distinct[] = $log_last_day[$i];
    }
  }

  $array_final = [];
  foreach ($log_last_day_distinct as $key => $value) {
    $array_final[$value] = 0;
  }

  foreach ($array_final as $key => $value) {
    foreach ($log_last_day as $log) {
      if ($key == $log) {
        $array_final[$key] += 1;
      }
    }
  }

  $total = 0;

  foreach ($array_final as $element) {
    $total += $element;
  }

  $number_of_logged_users = count(file(LOGGED_USERS));
}
