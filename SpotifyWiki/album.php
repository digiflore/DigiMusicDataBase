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
      require_once '../public/php/SeekerCommunicator.php';

      // Envoi l'url à l'historique de navigation
      $current_url = GetCurrentURL();
      $communicator = new SeekerCommunicator();
      $communicator->AddURL($current_url, "album");

      $spotify = new SpotifyApi();
      $album = $spotify->GetAlbumById($_GET['album_id']);
      $my_artists = array();
      foreach ($album->artists as $artist)
        array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
      $artists = implode(", ", $my_artists);
      $release_date = $album->release_date;
      $dateFr = date("d/m/Y", strtotime($release_date));
      ?>
      <br><br>
      <img class="picture" src="<?= $album->images[0]->url ?>" alt=" Image non disponible" />
      <?= $album->name ?><br>
      <?= $artists ?><br>
      <a href=" <?= $album->uri ?>" title="Ouvrir dans Spotify"><img class="icon" src="../public/images/spotify.png" /></a><br>
      Date de sortie : <?= $dateFr ?><br>
      <?= $album->copyrights[0]->text ?><br>
      <?php
      $lib = "";
      if ($album->total_tracks > 1)
        $lib = "titres";
      else
        $lib = "titre";
      ?>
      <?= $album->total_tracks ?> <?= $lib ?>
      </div>
      <br><br>
      <?php
      $tracks = $spotify->GetAlbumTracks($_GET['album_id']);
      ?>
      <br><br>
      <table>
        <tr>
          <th></th>
          <th>Titre</th>
          <th>Artistes</th>
          <th>Durée</th>
          <th></th>
        </tr>
        <?php
        foreach ($tracks->items as $track) {
          //var_dump($track);
          $my_artists = array();
          foreach ($track->artists as $artist) {
            $communicator->AddArtist($artist->id);
            array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
          }
          $artists = implode(", ", $my_artists);
        ?>
          <tr>
            <td class=id><?= $track->track_number ?></td>
            <td><?= $track->name ?></td>
            <td><?= $artists ?></td>
            <td><?= FormatMilliseconds($track->duration_ms) ?></td>
            <td class='link'><a href="<?= $track->uri ?>" title="Ouvrir dans Spotify"><img class="icon" src="../public/images/spotify.png" /></a></td>
          </tr>
        <?php
        }
        ?>
      </table>
</body>

</html>