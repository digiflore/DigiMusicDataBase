<!DOCTYPE html>
<html lang="fr">

<head>
  <title>DigiMusicDataBase</title>
  <link rel="stylesheet" type="text/css" href="../public/css/style.css?t=<?= time() ?>" title="Default Styles" media="screen">
</head>

<?php
require_once '../api/spotify-api.php';
require_once '../public/php/functions.php';

?>
<h1>Recherche Spotify</h1>
<form action='index.php?q=search' method="post" id="sectionForm">
  <input id=query name=query placeholder="Mots clés" required value="<?= isset($_GET['query']) ? $_GET['query'] : ""; ?>" />
  <input id='submit' type='submit' id='send' name='send' value='Recherche'>
</form>
<br />
<br />

<?php
$spotify = new SpotifyApi();
$offset = 0;
$limit = 5;
$max = 30;

$current_url = GetCurrentURL();
$communicator = new SeekerCommunicator();
$communicator->AddURL($current_url, "search");

if (isset($_POST['send'])) {
  if (isset($_POST['query']) && $_POST['send'] == "Recherche") {
?>
    <button class="filter" onclick="DisplayAll()">Tout</button>
    <button class="filter" onclick="DisplayAlbums()">Albums</button>
    <button class="filter" onclick="DisplayArtists()">Artistes</button>
    <button class="filter" onclick="DisplayTracks()">Titres</button>
    <br><br>
    <br><br>
    <?php

    echo "Résultats des recherches pour : <i>" . $_POST['query'] . "</i><br/><br/>";
    ?>
    <br><br>

    <h2 style="text-align: left;">Albums</h2>
    <?php
    $search_results = $spotify->Search($_POST['query'], "album", $offset, $limit);
    ?>
    <!-- tbAlbums -->
    <div class="results" id=tbAlbums>
      <?php
      $id = 0;
      while ($id < $max && isset($search_results)) {
        if (isset($search_results->albums)) {
          $albums = $search_results->albums;
          foreach ($albums->items as $album) {
      ?>
            <div class="item">
              <?php
              $id = $id + 1;
              ?>
              <a href="./album.php?album_id=<?= $album->id ?>"><img class=picture src="<?= isset($album->images[0]->url) ? $album->images[0]->url : "./images/no.jpg" ?>" alt="Aucune image disponible" /></a><br>
              <?php
              $my_artists = array();
              foreach ($album->artists as $artist)
                array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");

              $artists = implode(", ", $my_artists);
              ?>
              <center><i><?= $album->name ?></i> de <b><?= $artists ?></b></center>
            </div>
      <?php
          }
          if (isset($albums->next))
            $search_results = $spotify->GetResults($albums->next);
          else
            $search_results = null;
        }
      }
      ?>
    </div>
    <!-- tbAlbums -->

    <h2 style="text-align: left;">Artistes</h2>
    <?php
    $search_results = $spotify->Search($_GET['query'], "artist", $offset, $limit);
    ?>
    <!-- tbArtists -->
    <div class="results" id=tbArtists>
      <?php
      $id = 0;
      while ($id < $max && isset($search_results)) {
        if (isset($search_results->artists)) {
          $artists = $search_results->artists;
          foreach ($artists->items as $artist) {
      ?>
            <div class="item">
              <?php
              $id = $id + 1;
              ?>
              <a href="./artist.php?artist_id=<?= $artist->id ?>"><img class=picture src="<?= isset($artist->images[0]->url) ? $artist->images[0]->url : "./images/no.jpg" ?>" alt="Aucune image disponible" /></a><br>
              <center><b><?= $artist->name ?></b></center>
            </div>
      <?php
          }
          if (isset($artists->next))
            $search_results = $spotify->GetResults($artists->next);
          else
            $search_results = null;
        }
      }
      ?>
    </div>
    <!-- tbArtists -->

    <!-- tbTrack -->
    <h2 style="text-align: left;">Titres</h2>
    <?php
    $search_results = $spotify->Search($_GET['query'], "track", $offset, $limit);
    ?>
    <div class="results" id=tbTrack>
      <?php
      $id = 0;
      while ($id < $max && isset($search_results)) {
        if (isset($search_results->tracks)) {
          $tracks = $search_results->tracks;
          foreach ($tracks->items as $track) {
      ?>
            <div class="item">
              <?php
              $id = $id + 1;
              $album = $track->album;
              $my_artists = array();
              foreach ($album->artists as $artist)
                array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
              $artists = implode(", ", $my_artists);
              ?>
              <a href="./SpotifyWiki/album.php?album_id=<?= $album->id ?>"><img class=picture src="<?= isset($album->images[0]->url) ? $album->images[0]->url : "./images/no.jpg" ?>" alt="Aucune image disponible" /></a><br>
              <i><?= $track->name ?></i> dans l'album <a href="./SpotifyWiki/album.php?album_id=<?= $album->id ?>"><?= $album->name ?></a>
              de <b><?= $artists ?></b>
            </div>
      <?php
          }
          if (isset($tracks->next))
            $search_results = $spotify->GetResults($tracks->next);
          else
            $search_results = null;
        }
      }
      ?>
    </div>
    <!-- tbTrack -->
<?php
  }
} ?>
<script src=" ../public/js/ToggleSearch.js"></script>
</body>

</html>