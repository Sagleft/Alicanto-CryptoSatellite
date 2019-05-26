<?php
	header('Access-Control-Allow-Origin: *');
	require_once __DIR__ . "/../vendor/autoload.php";
	use \Alicanto\Utilities as Utils;
	
	$enviro = new \Alicanto\Environment();
	$logic  = new \Alicanto\Logic();
	
	$address = Utils::data_filter($_GET['addr']);
	//TODO: verify address
	
	//TODO: это всё можно перенести в какой-нибудь route-скрипт
	//при желании
	//(но его пока нет)
	echo $logic->getbalance($address);
	