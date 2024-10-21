<?php
require_once '../public/php/functions.php';

final class SearchLink
{
  public string $link;
  public string $type;
  public string $current_date;

  public function __construct($link, $type)
  {
    $this->link = $link;
    $this->type = $type;
    $this->current_date = GetCurrentDateTime();
  }
}
