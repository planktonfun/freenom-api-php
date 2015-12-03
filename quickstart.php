<?php

require_once 'vendor/autoload.php';

define('APPLICATION_NAME', 'FreeNom Shorten URL API');
define('CREDENTIALS_PATH', '~/.credentials/freenom-php-api.json');

$details = [
	'domain' => 'google.com',
	'prefix' => 'https://',
	'type'   => 'FREE'
];

$cli    = new Freenom_Client;
$client = $cli->getClient();

try {
	$service = new Freenom_Service($client);
	$service->ping();

	$contact = new Freenom_Contact($client);
	var_dump($contact->getList());
	var_dump($contact->getInfo(['contactId'=>1]));

	$domain      = new Freenom_Domain($client);
	$listDomains = $domain->listDomains(['maxResults'=>100]);
	var_dump($listDomains);

	$search = $domain->search([
		'name' => $details['domain'],
		'type' => $details['type']
	]);
	var_dump($search);

	$register = $domain->shortenURL([
		'url' => $details['prefix'].$details['domain']
	]);
	var_dump($register);

} catch(Freenom_Authorize_Exception $e) {
	var_dump(get_class($e), $e->getMessage(), $e->getCode());

} catch(Freenom_Service_Exception $e) {
	var_dump(get_class($e), $e->getMessage(), $e->getCode());

} catch(Freenom_Request_Exception $e) {
	var_dump(get_class($e), $e->getMessage(), $e->getCode());

} catch(Freenom_Exception $e) {
	var_dump(get_class($e), $e->getMessage(), $e->getCode(), $e->getErrorArray());

} catch(Exception $e) {
	var_dump(get_class($e), $e->getMessage(), $e->getCode());

}