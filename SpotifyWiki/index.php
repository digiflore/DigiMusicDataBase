<!DOCTYPE html>
<html lang="fr">

<head>
  <title>DigiMusicDataBase</title>
  <link rel="stylesheet" type="text/css" href="../public/css/style.css?t=<?= time() ?>" title="Default Styles" media="screen">
</head>

<a>
  <?php
  require_once '../api/spotify-api.php';

  function FilterByName($name) {}
  ?>
  <h1>Recherche Spotify</h1>
  <form action='' method="get" id="sectionForm">
    <input id=query name=query placeholder="Mots clés" required value="<?= isset($_GET['query']) ? $_GET['query'] : ""; ?>" />
    <input id='submit' type='submit' id='send' name='send' value='Recherche'>
  </form>
  <br />
  <br />
</a>
<?php
$spotify = new SpotifyApi();
$offset = 0;
$limit = 5;
$max = 30;
if (isset($_GET['send'])) {
  if (isset($_GET['query']) && $_GET['send'] = "Recherche") {
?>
    <button class="filter" onclick="DisplayAll()">Tout</button>
    <button class="filter" onclick="DisplayAlbums()">Albums</button>
    <button class="filter" onclick="DisplayArtists()">Artistes</button>
    <button class="filter" onclick="DisplayTracks()">Titres</button>
    <br><br>
    <br><br>
    <?php
    echo "Résultats des recherches pour : <i>" . $_GET['query'] . "</i><br/><br/>";
    ?>
    <br><br>
    <?php
    $search_results = $spotify->Search($_GET['query'], "album", $offset, $limit);
    ?>
    <table id=tbAlbums>
      <tr>
        <td>
          <h2 style="text-align: left;">Albums</h2>
        </td>
      </tr>
      <?php
      $id = 0;
      while ($id < $max && isset($search_results)) {
      ?>
        <?php
        if (isset($search_results->albums)) {
        ?>
          <tr>
            <?php
            $albums = $search_results->albums;
            foreach ($albums->items as $album) {
            ?>
              <td style="width: 10%;">
                <?php
                //  var_dump($album);
                $id = $id + 1;
                ?>
                <a href="./album.php?album_id=<?= $album->id ?>"><img class=picture src="<?= isset($album->images[0]->url) ? $album->images[0]->url : "" ?>" /></a><br>
                <?php
                $my_artists = array();
                foreach ($album->artists as $artist)
                  array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");

                $artists = implode(", ", $my_artists);
                ?>
                <i><?= $album->name ?></i> de <b><?= $artists ?></b>
              </td>
          <?php
            }
          }
          if (isset($albums->next))
            $search_results = $spotify->SendUrl($albums->next);
          else
            $search_results = null;
          ?>
          </tr>
        <?php } ?>
    </table>
    <br>
    <?php
    $search_results = $spotify->Search($_GET['query'], "artist", $offset, $limit);
    ?>
    <table id=tbArtists>
      <tr>
        <td>
          <h2 style="text-align: left;">Artistes</h2>
        </td>
      </tr>
      <?php
      $id = 0;
      $name = "artists";
      while ($id < $max && isset($search_results)) {
      ?>
        <?php
        if (isset($search_results->$name)) {
        ?>
          <tr>
            <?php
            $artists = $search_results->artists;
            foreach ($artists->items as $artist) {
            ?>
              <td style="width: 10%;">
                <?php
                $id = $id + 1;
                ?>
                <a href="./artist.php?artist_id=<?= $artist->id ?>"><img class=picture src="<?= isset($artist->images[0]->url) ? $artist->images[0]->url : "" ?>" /></a><br>
                <b><?= $artist->name ?></b>
              </td>
          <?php
            }
          }
          if (isset($artists->next))
            $search_results = $spotify->SendUrl($artists->next);
          else
            $search_results = null;
          ?>
          </tr>
        <?php } ?>
    </table>

    <?php
    //}
    //if (isset($_GET['track'])) {
    $search_results = $spotify->Search($_GET['query'], "track", $offset, $limit);
    ?>
    <table id=tbTrack>
      <tr>
        <td>
          <h2 style="text-align: left;">Titres</h2>
        </td>
      </tr>
      <?php
      $id = 0;
      $name = "tracks";
      while ($id < $max && isset($search_results)) {
      ?>
        <?php
        if (isset($search_results->$name)) {
        ?>
          <tr>
            <?php
            $tracks = $search_results->tracks;
            foreach ($tracks->items as $track) {
              //var_dump($track);
            ?>
              <td style="width: 10%;">
                <?php
                $id = $id + 1;
                $album = $track->album;
                $my_artists = array();
                foreach ($album->artists as $artist)
                  array_push($my_artists, "<a href='./artist.php?artist_id=$artist->id'>$artist->name</a>");
                $artists = implode(", ", $my_artists);
                ?>
                <a href="./album.php?album_id=<?= $album->id ?>"><img class=picture src="<?= isset($album->images[0]->url) ? $album->images[0]->url : "" ?>" /></a><br>
                <i><?= $track->name ?></i> dans l'album <a href="./album.php?album_id=<?= $album->id ?>"><?= $album->name ?></a>
                de <b><?= $artists ?></b>
              </td>
          <?php
            }
          }
          if (isset($tracks->next))
            $search_results = $spotify->SendUrl($tracks->next);
          else
            $search_results = null;
          ?>
          </tr>
        <?php } ?>
    </table>
<?php
    //}
  }
} ?>

<script src=" ../public/js/ToggleSearch.js"></script>
<script>

</script>

</body>