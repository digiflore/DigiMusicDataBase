<?php

class MyArtists
{
  private $artists;
  private $file = __DIR__ . '/json/artists.json';

  public function __construct()
  {
    CreateFile($this->file);
    $this->LoadJsonFile();
  }

  public function AddArtist(string $artist)
  {
    array_push($this->artists, $artist);
    $this->SendToJsonFile();
  }

  public function FindArtist(string $artist)
  {
    $i = 0;
    $bFound = false;
    while ($i < count($this->artists) && $bFound == false) {
      if ($artist == $this->artists[$i]) {
        $bFound = true;
      } else {
        $i++;
      }
    }
    return $bFound;
  }

  public function SendToJsonFile()
  {
    // Convert the PHP data to a JSON string
    $json_string = json_encode($this->artists);
    file_put_contents($this->file, $json_string);
  }

  public function LoadJsonFile()
  {
    $json_string = file_get_contents($this->file);

    $data = json_decode($json_string, true);

    if (isset($data))
      $this->artists = $data;
    else
      $this->artists = array();
  }
}
