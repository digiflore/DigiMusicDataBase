<?php
require_once dirname(__FILE__) . '/../../DJ_Seeker/index.php';

class SeekerCommunicator
{
  public MyLinks $my_links;
  public MyArtists $my_artists;

  function __construct()
  {
    $this->my_links = new MyLinks();
    $this->my_artists = new MyArtists();
  }

  function AddURL($url, $type)
  {
    $this->my_links->AddLink($url, $type);
  }

  function AddArtist($artist_id)
  {
    if (!$this->my_artists->FindArtist($artist_id))
      $this->my_artists->AddArtist($artist_id);
  }
}
