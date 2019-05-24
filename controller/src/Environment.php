<?php
	namespace Alicanto;
	class Environment {
		protected $config = [];
		//сюда можно добавить параметры для подключения к БД,
		//если потребуется
		private $params = [
			'db_host', 'db_user', 'db_password', 'db_name', 'version'
		];
		
		function __construct() {
			$this->loadFromENV();
		}
		
		function loadFromENV() {
			$dotenv = \Dotenv\Dotenv::create(__DIR__ . "/../../model/");
			$dotenv->load();
			
			$new_config = [];
			for($i=0; $i<count($this->params); $i++) {
				$param = $this->params [$i];
				$new_config[$param] = getenv($param);
			}
			$this->config = $new_config;
		}
		
		function getResVersion() {
			//TODO: заменить на что-нибудь получше
			return $config['version'];
		}
	}
	