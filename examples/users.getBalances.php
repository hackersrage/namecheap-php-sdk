<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);

include_once '../Api.php';

try
{
	$config = new \Namecheap\Config();
	$config->apiUser('api-username')
		->apiKey('api-key')
		->clientIp('your-ip')
		->sandbox(true);

	$command = Namecheap\Api::factory($config, 'users.getBalances');
	$command->dispatch();
} catch (\Exception $e) {
	die($e->getMessage());
}

d($command);

function d($value = array())
{
	echo '<pre>' . "\n";
	print_r($value);
	die('</pre>' . "\n");
}
