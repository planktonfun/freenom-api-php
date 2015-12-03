# Freenom APIs Library for PHP

# Requirements
PHP 5.4.0 or higher

# Developer Documentation
http://www.freenom.com/en/freenom-api.html

# Basic Example
Saved in file quickstart.php

    // Include all Freenom classes
    require_once 'vendor/autoload.php';
    
    define('CREDENTIALS_PATH', '~/.credentials/{CREDENTIAL_FILENAME}');
    
    $cli    = new Freenom_Client;
    $client = $cli->getClient();
    
    $service = new Freenom_Service($client);
    $service->ping();
	  
    $register = $domain->shortenURL([
  	'url' => $details['prefix'].$details['domain']
    ]);
    var_dump($register);
    
    $domain      = new Freenom_Domain($client);
    $listDomains = $domain->listDomains(['maxResults'=>100]);
    var_dump($listDomains);
  	
You can view it by running php in terminal.

    $ php {YOUR_FILE}.php
