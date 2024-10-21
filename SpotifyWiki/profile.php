<!DOCTYPE html>
<html lang="fr">

<head>
  <title>DigiMusicDataBase</title>
  <link rel="stylesheet" type="text/css" href="../public/css/style.css?t=<?= time() ?>" title="Default Styles" media="screen">
</head>

<?php
require_once '../api/spotify-api.php';
?>
<?php
$spotify = new SpotifyApi();
$me = $spotify->GetUserProfile();
//var_dump($me);
?>
<h1><?= $me->display_name ?></h1>
<a href="<?= $me->uri ?>" title="Ouvrir dans Spotify"><img class="icon" src="../images/spotify.png" alt=""></a>