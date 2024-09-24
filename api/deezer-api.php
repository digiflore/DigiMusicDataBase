<?php

class DeezerApi
{
  private $curl;
  function __construct()
  {
    $this->curl = curl_init();
    // ne pas toucher, sinon le certificat cURL ne fonctionne pas
    $certificate_location = '/usr/local/openssl-0.9.8/certs/cacert.pem';
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, $certificate_location);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $certificate_location);
  }

  private function GetCurl($url)
  {
    curl_setopt_array($this->curl, [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: deezerdevs-deezer.p.rapidapi.com",
        "x-rapidapi-key: b6b3910c76mshdb038f3b98bd8b2p16c9d2jsn14d0e7af6efb"
      ],
    ]);

    $response = curl_exec($this->curl);
    $err = curl_error($this->curl);

    curl_close($this->curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      //echo $response;
      //file_put_contents('data.json', $response);
    }
    return $response;
  }

  public function GetArtist($param)
  {
    $url = "https://deezerdevs-deezer.p.rapidapi.com/artist/" . $param;
    $response = $this->GetCurl($url);
    return $response;
  }

  public function Search($param)
  {
    $url = "https://deezerdevs-deezer.p.rapidapi.com/search?q=" . $param;
    $response = $this->GetCurl($url);
    return $response;
  }
}
