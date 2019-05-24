<?php
	namespace Alicanto;
	class Logic {
		private $coin_connection = null;
		private $cryptoID_url = "";
		//private $utils = null;
		
		public function __construct() {
			//use \Alicanto\Utilities as AppUtils;
			//$this->utils = new AppUtils();
			//\Alicanto\Utilities::data_filter
			
			$this->cryptoID_url = "https://chainz.cryptoid.info/" . getenv('cryptoID_coin') . "/api.dws?key=" . getenv('cryptoID_key');
		}
		
		function coin_connect() {
			$this->coin_connection = new \Denpa\Bitcoin\Client([
				'scheme'   => 'http',             // optional, default http
				'host'     => getenv('rpc_host'), // optional, default localhost
				'port'     => getenv('rpc_port'), // optional, default 8332
				'user'     => getenv('rpc_user'), // required
				'password' => getenv('rpc_pass')  // required
			]);
		}
		
		function getUtxo($address) {
			//TODO: сделать что-то другое и универсальное
			//возможно, для cryptoID вынести параметры куда-нибудь
			$api_url = $this->cryptoID_url . "&q=unspent&a=" . $address;
			$result = \Alicanto\Utilities::curl_get($api_url);
			//test
			exit(var_dump($result));
		}
	}
	