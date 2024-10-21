<?php
//https://rapidapi.com/Glavier/api/spotify23/playground/apiendpoint_1dc51f1b-a2c6-4f9a-9c6c-32019c7301b2
class SpotifyApi
{
  private $token;

  // mes identifiants Developer Spotify
  private $client_id = '02b35e78d66e4b3a83f4d50c3ca1c85a';
  private $client_secret = '710926aefc164a248c8752ee79a42501';

  // mon id Spotify :
  private $my_id = "31ykcqqssoyammlsox5abhz36mnu";

  // Crée un objet cURL
  function __construct() {}
  function CallSpotifyApi($options)
  {
    $curl  = curl_init();
    curl_setopt_array($curl, $options);
    $json  = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error) {
      return [
        'error'   => TRUE,
        'message' => $error
      ];
    }
    $data  = json_decode($json);
    if (is_null($data)) {
      return [
        'error'   => TRUE,
        'message' => json_last_error_msg()
      ];
    }
    return $data;
  }

  public function GetToken()
  {
    /*$this->curl = curl_init();
    curl_setopt($this->curl, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret)));
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.x.x) Gecko/20041107 Firefox/x.x");
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

    $json = curl_exec($this->curl);
    $err = curl_error($this->curl);
    $json = json_decode($json);
    curl_close($this->curl);
    if ($err) {
      echo "cURL Error #:" . $err;
      curl_close($this->curl);
    }
    $this->authorization = "Authorization: Bearer " . $json->access_token;
    */
    $headers  = ['Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret)];
    $url      = 'https://accounts.spotify.com/api/token';
    $options  = [
      CURLOPT_URL            => $url,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_SSL_VERIFYHOST => FALSE,
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_POST           => TRUE,
      CURLOPT_POSTFIELDS     => 'grant_type=client_credentials',
      CURLOPT_HTTPHEADER     => $headers
    ];
    $credentials = $this->CallSpotifyApi($options);
    $this->token = $credentials->access_token;
  }

  public function GetResults($url)
  {
    $this->GetToken();

    $headers  = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->token
    ];
    //$url      = 'https://api.spotify.com/v1/audio-features/' . $spotify_track;
    $options  = [
      CURLOPT_URL            => $url,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_SSL_VERIFYHOST => FALSE,
      CURLOPT_SSL_VERIFYPEER => FALSE,
      CURLOPT_FOLLOWLOCATION => TRUE,
      CURLOPT_ENCODING       => '',
      CURLOPT_MAXREDIRS      => 10,
      CURLOPT_TIMEOUT        => 30,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST  => 'GET',
      CURLOPT_HTTPHEADER     => $headers
    ];
    $features = $this->CallSpotifyApi($options);
    return $features;
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

  public function GetProfile()
  {
    $url = 'https://api.spotify.com/v1/me';
    $results = $this->GetResults($url);
    return $results;
  }

  public function GetUserProfile()
  {
    $url = 'https://api.spotify.com/v1/users/' . $this->my_id;
    $results = $this->GetResults($url);
    return $results;
  }
}
