<?php
	require_once __DIR__ . "/../vendor/autoload.php";
	//use \Alicanto\Environment as AppEnvironment;
	
	$enviro = new \Alicanto\Environment();
	$logic  = new \Alicanto\Logic();
	
	//test
	$logic->getUtxo("MXic5qsSFDFnC2CiHe36txKK328Z3t9oaz");
	