<?php
//https://rapidapi.com/Glavier/api/spotify23/playground/apiendpoint_1dc51f1b-a2c6-4f9a-9c6c-32019c7301b2
class SpotifyApi
{
  private $curl;
  private $authorization;

  // mes identifiants Developer Spotify
  private $client_id = '02b35e78d66e4b3a83f4d50c3ca1c85a';
  private $client_secret = '710926aefc164a248c8752ee79a42501';

  // Crée un objet cURL
  function __construct() {}

  public function GetToken()
  {
    $this->curl = curl_init();
    curl_setopt($this->curl, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret)));
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

    $json = curl_exec($this->curl);
    $json = json_decode($json);
    curl_close($this->curl);

    $this->authorization = "Authorization: Bearer " . $json->access_token;

    return $json->access_token;
  }

  private function GetResults($url)
  {
    $this->GetToken();

    $this->curl = curl_init();

    curl_setopt($this->curl, CURLOPT_URL, $url);
    curl_setopt($this->curl,  CURLOPT_HTTPHEADER, array('Content-Type: application/json', $this->authorization));
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
    $results = curl_exec($this->curl);
    $results = json_decode($results);
    curl_close($this->curl);
    return $results;
  }

  // Search
  public function SendUrl(string $url)
  {
    $results = $this->GetResults($url);
    return $results;
  }

  // Search
  public function Search(string $query, string $type, int $offset, int $limit)
  {
    $url = 'https://api.spotify.com/v1/search?query=' . urlencode($query) . '&type=' . urlencode($type) . '&locale=fr-FR&offset=' . urlencode($offset) . '&limit=' . $limit;
    $results = $this->GetResults($url);
    return $results;
  }

  // Albums
  public function GetAlbumById($idAlbum)
  {
    $url = 'https://api.spotify.com/v1/albums/' . $idAlbum;

    $results = $this->GetResults($url);
    return $results;
  }
  public function GetAlbumsByArtistId($idArtist)
  {
    $url = 'https://api.spotify.com/v1/artists/' . $idArtist . '/albums';

    $results = $this->GetResults($url);
    return $results;
  }

  public function GetAlbumTracks($idAlbums)
  {
    $url = 'https://api.spotify.com/v1/albums/' . $idAlbums . '/tracks';

    $results = $this->GetResults($url);
    return $results;
  }

  public function GetArtistById($idArtist)
  {
    $url = 'https://api.spotify.com/v1/artists/' . $idArtist;

    $results = $this->GetResults($url);
    return $results;
  }
}
