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
      $album = $spotify->GetAlbumById($_GET['album_id']);
      $my_artists = array();
      foreach ($album->artists as $artist)
        array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
      $artists = implode(", ", $my_artists);
      $release_date = $album->release_date;
      $dateFr = date("d/m/Y", strtotime($release_date));
      ?>
      <br><br>
      <table>
        <tr>
          <td width=100px rowspan="5">
            <img class="picture" src="<?= $album->images[0]->url ?>" alt=" Image non disponible" />
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
          <td><?= $album->label ?></td>
        </tr>
      </table>
      <br><br>
      <?php
      $tracks = $spotify->GetAlbumTracks($_GET['album_id']);

      $lib = "";
      if ($album->total_tracks > 1)
        $lib = "titres";
      else
        $lib = "titre";
      ?>
      <?= $album->total_tracks ?> <?= $lib ?>
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
          // var_dump($track);
          $my_artists = array();
          foreach ($track->artists as $artist)
            array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
          $artists = implode(", ", $my_artists);
        ?>
          <tr>
            <td class=id><?= $track->track_number ?></td>
            <td><?= $track->name ?></td>
            <td><?= $artists ?></td>
            <td><?= FormatMilliseconds($track->duration_ms) ?></td>
            <td class='link'><a href="<?= $track->uri ?>" title="Ouvrir dans Spotify"><img class="icon" src="../images/spotify.png" /></a></td>
          </tr>
        <?php
        }
        ?>
      </table>
</body>

</html>