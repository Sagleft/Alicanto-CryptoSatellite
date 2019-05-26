<?php
	header('Access-Control-Allow-Origin: *');
	require_once __DIR__ . "/../vendor/autoload.php";
	use \Alicanto\Utilities as Utils;
	
	$enviro = new \Alicanto\Environment();
	$logic  = new \Alicanto\Logic();
	
	$address = Utils::data_filter($_GET['addr']);
	//TODO: verify address
	
	//запрос последних транзакций по адресу
	echo $logic->getLastTxs($address);
	