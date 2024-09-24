<!DOCTYPE html>
<html>

<head>
  <title>DigiMusicDataBase</title>
</head>

<body>
  <?php
  require_once("./config/site.php");
  ?>
  <center>
    <h1>Banque de données musicale</h1>
    <h2>Bienvenue dans ma banque de données musicale.</h2>
  </center>
  <br><br>
  Veuillez sélectionner la plateforme de musique pour consulter les données.
  <br><br>
  <form method="post" action="./SpotifyWiki/index.php">
    <input type="submit" value="Spotify" />
  </form>
</body>

</html>