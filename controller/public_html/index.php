<?php
	require_once __DIR__ . "/../vendor/autoload.php";
	use \Alicanto\Render as AppRender;
	use \Alicanto\Environment as AppEnvironment;
	
	$enviro = new AppEnvironment();
	$render = new AppRender([
		'tag'  => 'home',
		'host' => getenv('host'),
		'coin' => 'MFCoin'
	]);
	$render->twigRender();
	