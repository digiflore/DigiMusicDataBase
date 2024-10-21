<?php
require_once 'SearchLink.php';
$dir = dirname(__FILE__);

class MyLinks
{
  private $links;
  private $file = __DIR__ . '/json/history.json';

  public function __construct()
  {
    CreateFile($this->file);
    $this->LoadJsonFile();
  }

  public function AddLink(string $link, string $type)
  {
    $search_link = new SearchLink($link, $type);
    array_push($this->links, $search_link);
    $this->SendToJsonFile();
  }

  public function SendToJsonFile()
  {
    // Convert the PHP data to a JSON string
    $json_string = json_encode($this->links);
    file_put_contents($this->file, $json_string);
  }

  public function LoadJsonFile()
  {
    $json_string = file_get_contents($this->file) or die("Fichier des liens introuvable.");

    $data = json_decode($json_string, true);

    if (isset($data))
      $this->links = $data;
    else
      $this->links = array();
  }
}
