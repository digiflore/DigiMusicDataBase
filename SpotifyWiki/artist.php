<!DOCTYPE html>
<html lang="fr">

<head>
  <title>DigiMusicDataBase</title>
  <link rel="stylesheet" type="text/css" href="../public/css/style.css?t=<?= time() ?>" title="Default Styles" media="screen">
</head>

<body>
  <a href="./index.php">
    << </a>
      <?php
      require_once('../api/spotify-api.php');
      require_once('../public/php/functions.php');

      $spotify = new SpotifyApi();
      $artist = $spotify->GetArtistById($_GET['artist_id']);
      ?>
      <!-- Récupère le nom de l'artiste -->
      <h1>Liste des albums de <?= $artist->name ?></h1>
      <?php
      $albums = $spotify->GetAlbumsByArtistId($_GET['artist_id']);
      echo "Il y a " . count($albums->items) . " albums.<br><br>";
      foreach ($albums->items as $album) {
        //var_dump($album);
        $album_id = $album->id;
        $my_artists = array();
        foreach ($album->artists as $artist)
          array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
        $artists = implode(", ", $my_artists);
        $release_date = $album->release_date;
        $dateFr = date("d-m-Y", strtotime($release_date));
      ?>
        <table>
          <tr>
            <td width=100px rowspan="5">
              <a href="./album.php?album_id=<?= $album->id ?>"><img class="picture" src="<?= $album->images[0]->url ?>" alt=" Image non disponible" /></a>
            </td>
            <td>
              <h2><?= $album->name ?></h2>
            </td>
          </tr>
          <tr>
            <td><?= $artists ?></td>
          </tr>
          <tr>
            <td><a href=" <?= $album->uri ?>" title="Ouvrir dans Spotify"><img class="icon" src="../images/spotify.png" /></a></td>
          </tr>
          <tr>
            <td>Date de sortie : <?= $dateFr ?></td>
          </tr>
          <tr>
            <?php
            $lib = "";
            if ($album->total_tracks > 1)
              $lib = "titres";
            else
              $lib = "titre";
            ?>
            <td><?= $album->total_tracks ?> <?= $lib ?></td>
          </tr>
        </table>
        <br><br>
      <?php
      }
      ?>
</body>