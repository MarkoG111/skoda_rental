<?php

session_start();

function autoload($className)
{
  $className = ltrim($className, '\\');
  $fileName  = '';
  $namespace = '';
  if ($lastNsPos = strrpos($className, '\\')) {
    $namespace = substr($className, 0, $lastNsPos);
    $className = substr($className, $lastNsPos + 1);
    $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
  }
  $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

  require $fileName;
}
spl_autoload_register('autoload');


function printTitle()
{
  $url = explode("&", $_SERVER["REQUEST_URI"]);
  // var_dump($url);
  $urlBase = "/Skoda_Rent/";

  switch ($url[0]) {
    case "{$urlBase}":
      echo "<title>Škoda - Home</title>";
      break;
    case "{$urlBase}index.php":
      echo "<title>Škoda - Home</title>";
      break;
    case "{$urlBase}index.php?page=home":
      echo "<title>Škoda - Home</title>";
      break;
    case "{$urlBase}index.php?page=models":
      echo "<title>Škoda - Models</title>";
      break;
  }
}

function printDescription()
{
  $url = explode("&", $_SERVER["REQUEST_URI"]);
  $urlBase = "/Skoda_Rent/";
  $contet = "";

  switch ($url[0]) {
    case "{$urlBase}":
      $contet = "Keep up to date with the presentation of new models, technological changes and innovations in designer interiors and exteriors.";
      break;
    case "{$urlBase}index.php":
      $contet = "Keep up to date with the presentation of new models, technological changes and innovations in designer interiors and exteriors.";
      break;
    case "{$urlBase}index.php?page=home":
      $contet = "Keep up to date with the presentation of new models, technological changes and innovations in designer interiors and exteriors.";
      break;
    case "{$urlBase}index.php?page=models":
      $contet = "Get to know all of the newest Skoda models.";
      break;
  }

  echo "<meta name=\"description\" content=\"{$contet}\" />";
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
