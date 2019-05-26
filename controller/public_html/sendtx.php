<?php
	header('Access-Control-Allow-Origin: *');
	require_once __DIR__ . "/../vendor/autoload.php";
	//use \Alicanto\Environment as AppEnvironment;
	use \Alicanto\Utilities as Utils;
	
	$enviro = new \Alicanto\Environment();
	$logic  = new \Alicanto\Logic();
	
	$rawtx = Utils::data_filter($_POST['rawtx']);
	//TODO: verify rawtx
	
	echo $logic->sendTx($rawtx);
	