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
      $communicator->AddURL($current_url, "artist");

      $spotify = new SpotifyApi();

      $res = $spotify->GetResults("https://api.spotify.com/v1/artists/" . $_GET['artist_id'] . "/related-artists");
      $infos_artists = array();
      foreach ($res->artists as $artist) {
        $infos_genres = array();
        foreach ($artist->genres as $genre) {
          array_push($infos_genres, $genre);
        }
        $id = $artist->id;
        $infos_artists[$id] = $infos_genres;
      }
      $artist = $spotify->GetArtistById($_GET['artist_id']);
      ?>
      <center><img class=picture src="<?= isset($artist->images[0]->url) ? $artist->images[0]->url : "./images/no.jpg" ?>" alt="Aucune image disponible" />

        <!-- Récupère le nom de l'artiste -->
        <h1>Liste des albums de <?= $artist->name ?></h1>
        <?php
        $my_genres = array();
        foreach ($artist->genres as $genre)
          array_push($my_genres, $genre);
        $genres = implode(", ", $my_genres);

        if (count($artist->genres) > 0) {
          SetLabel(count($artist->genres), "Genre", "Genres");
          " : " . $genres;
        }
        ?>
        <br><br>
      </center>
      <?php
      $albums = $spotify->GetAlbumsByArtistId($_GET['artist_id']);
      echo count($albums->items) . " " . SetLabel(count($albums->items), "album", "albums"); ?>

      <div class=results>
        <?php
        foreach ($albums->items as $album) {
          $album_id = $album->id;
          $my_genres = array();
          foreach ($album->artists as $artist)
            array_push($my_genres, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
          $artists = implode(", ", $my_genres);
          $release_date = $album->release_date;
          $dateFr = date("d-m-Y", strtotime($release_date));
        ?>
          <div class=item>
            <a href="./SpotifyWiki/album.php?album_id=<?= $album->id ?>"><img class="picture" src="<?= $album->images[0]->url ?>" alt=" Image non disponible" /></a>
            <?= $album->name ?><br>
            <?= $artists ?><br>
            <a href=" <?= $album->uri ?>" title="Ouvrir dans Spotify"><img class="icon" src="../images/spotify.png" /></a><br>
            Date de sortie : <?= $dateFr ?><br>
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
        }
        ?>
      </div>
</body>