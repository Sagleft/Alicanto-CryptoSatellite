<?php
	require_once __DIR__ . "/../vendor/autoload.php";
	use \Alicanto\Render as AppRender;
	use \Alicanto\Environment as AppEnvironment;
	
	$enviro = new AppEnvironment();
	$render = new AppRender([
		'tag'  => 'docs',
		'host' => 'http://satellite/',
		'coin' => 'MFCoin'
	]);
	$render->twigRender();
	