<?php
	require_once __DIR__ . "/../vendor/autoload.php";
	use \Alicanto\Render as AppRender;
	
	$render = new AppRender([
		'tag' => 'home'
	]);
	$render->twigRender();
	