<?php
function ConvertTime(int $seconds)
{
  $time = date('i:s', $seconds);
  return $time;
}

function FormatMilliseconds($milliseconds)
{
  $seconds = round($milliseconds / 1000, 0, PHP_ROUND_HALF_UP);

  // Calcule heures minutes et secondes
  $hours = floor($seconds / 3600);
  $seconds %= 3600;
  $minutes = floor($seconds / 60);
  $seconds %= 60;

  // Formate le résultat mm:ss
  $timeFormat = sprintf('%02d:%02d', $minutes, $seconds);

  return $timeFormat;
}

function GetCurrentURL()
{ // Récupère l'url en cours
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  return $current_url;
}

function GetCurrentDateTime()
{
  $tz = 'Europe/Paris';
  $timestamp = time();
  $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
  $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
  return $dt->format('d/m/Y H:i:s');
}

function SetLabel(int $count, string $lib_sing, string $lib_plur)
{
  if ($count > 1)
    return $lib_plur;
  else
    return $lib_sing;
}
