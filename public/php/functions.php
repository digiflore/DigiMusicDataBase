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
