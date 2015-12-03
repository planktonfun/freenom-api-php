<?php

class Freenom_Client
{
  protected $apiLoginId;
  protected $apiPassword;

  /**
   * Returns an authorized API client.
   * @return Freenom_Service the authorized client object
   */
  public function getClient()
  {
    $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);

    if (file_exists($credentialsPath)) {
      $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
      print 'Enter API Login ID: ';

      $apiLoginId = trim(fgets(STDIN));

      print 'Enter API Password: ';

      $apiPassword = trim(fgets(STDIN));
      $accessToken = ['apiLoginId'=>$apiLoginId, 'apiPassword'=>$apiPassword];

      if(!file_exists(dirname($credentialsPath))) {
        mkdir(dirname($credentialsPath), 0700, true);
      }

      file_put_contents($credentialsPath, json_encode($accessToken));
      printf("Credentials saved to %s\n", $credentialsPath);
    }

    $this->apiLoginId  = $accessToken['apiLoginId'];
    $this->apiPassword = $accessToken['apiPassword'];

    return $this;
  }

  public function getApiLoginId()
  {
    return $this->apiLoginId;
  }

  public function getApiPassword()
  {
    return $this->apiPassword;
  }

  /**
   * Expands the home directory alias '~' to the full path.
   * @param string $path the path to expand.
   * @return string the expanded path.
   */
  public function expandHomeDirectory($path)
  {
    $homeDirectory = getenv('HOME');

    if (empty($homeDirectory)) {
      $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
    }

    return str_replace('~', realpath($homeDirectory), $path);
  }

}