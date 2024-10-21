<?php
require_once 'My_links.php';
require_once 'My_artists.php';

if (!isset($my_links)) {
  $my_links = new MyLinks();
}
if (!isset($my_artists)) {
  $my_artists = new MyArtists();
}

function CreateFile($file)
{
  if (!file_exists($file))
    fopen($file, "w");
}
