<?php
	namespace Alicanto;
	
	class Render {
		private $data_wrap = ['page' => []];
		
		public function __construct($data) {
			$this->data_wrap = ['page' => $data];
		}
		
		function twigRender() {
			$loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../view/');
			$twig = new \Twig_Environment($loader, [
				'cache'       => __DIR__ . '/../../view/cache',
				'auto_reload' => true //TODO: сделать переменной
			]);
			exit($twig->render($this->data_wrap['page']['tag'] . ".tmpl", $this->data_wrap));
		}
	}
	