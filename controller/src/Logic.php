<?php
	namespace Alicanto;
	class Logic {
		private $coin_connection = null;
		private $cryptoID_url = "";
		//private $utils = null;
		
		public function __construct() {
			$this->cryptoID_url = "https://chainz.cryptoid.info/" . getenv('cryptoID_coin') . "/api.dws?key=" . getenv('cryptoID_key');
		}
		
		function validateAddress($address) {
			/* $result = $this->coin_connection->validateaddress($address);
			if($result['isvalid'] == true) {
				return true;
			} else {
				return false;
			} */
			//придется подключаться каждый раз при проверке
			if($address[0] == 'M' && strlen($address) == 34) {
				return true;
			} else {
				return false;
			}
		}
		
		function showError($info) {
			exit(json_encode([
				'status' => 'error',
				'data'   => [],
				'error'  => $info
			]));
		}
		
		function coin_connect() {
			/* $this->coin_connection = new \Denpa\Bitcoin\Client([
				'scheme'   => 'http',             // optional, default http
				'host'     => getenv('rpc_host'), // optional, default localhost
				'port'     => getenv('rpc_port'), // optional, default 8332
				'user'     => getenv('rpc_user'), // required
				'password' => getenv('rpc_pass')  // required
			]); */
			//простые решения зачастую работают стабильнее
			require_once __DIR__ . "/../src/coinrpc.php";
			$this->coin_connection = new \CoinRPC(getenv('rpc_user'), getenv('rpc_pass'));
			if($this->coin_connection->error != "") {
				$this->showError($this->coin_connection->error);
			}
		}
		
		function getUtxo($address) {
			if(!($this->validateAddress($address))) {
				return "";
			}
			//TODO: сделать что-то другое и универсальное
			//возможно, для cryptoID вынести параметры куда-нибудь
			$api_url = $this->cryptoID_url . "&q=unspent&active=" . $address;
			$result = \Alicanto\Utilities::curl_get($api_url);
			//TODO: test json
			$obj = json_decode($result);
			return json_encode($obj->unspent_outputs);
			//return $result;
		}
		
		function getbalance($address) {
			$result = "0";
			if($this->validateAddress($address)) {
				$api_url = "https://block2.mfcoin.net/ext/getbalance/" . $address;
				$result = \Alicanto\Utilities::curl_get($api_url);
			}
			return $result;
		}
		
		function sendTx($rawtx) {
			$this->coin_connect();
			$tx_id = $this->coin_connection->sendrawtransaction($rawtx);
			//if($tx_id == "") {
			//	$this->showError("Invalid rawtx or wallet error");
			//}
			return json_encode([
				'txid' => $tx_id
			]);
		}
		
		function getLastTxs($address) {
			if(!($this->validateAddress($address))) {
				return "";
			}
			$api_url = "https://block2.mfcoin.net/ext/getaddress/" . $address;
			$result = \Alicanto\Utilities::curl_get($api_url);
			//TODO: проверку json
			$obj = json_decode($result);
			$data_arr = $obj->last_txs;
			$txs = [];
			$tx_obj = [];
			//перебор данных
			//пусть не более 7 элементов
			$max_tr_count = 7;
			$tr_count = count($data_arr);
			if($tr_count > $max_tr_count) {
				$tr_count = $max_tr_count;
			}
			for($i=0; $i < $tr_count; $i++) {
				$tx_element = $data_arr[$i];
				$tx_id = $tx_element->addresses;
				//получаем данные о транзакции
				//$api_url = "https://block2.mfcoin.net/api/getrawtransaction?txid=" . $tx_id . "&decrypt=1";
				$api_url = $this->cryptoID_url . "&q=txinfo&t=" . $tx_id;
				$json = \Alicanto\Utilities::curl_get($api_url);
				//TODO: проверку json
				$tr_data = json_decode($json, true);
				
				if($tr_data['fees'] == null) {
					$fees = 0;
				} else {
					$fees = $tr_data['fees'];
				}
				
				$tx_obj = [
					'time'          => $tr_data['timestamp'],
					'txid'          => $tx_id,
					'fees'          => $fees,
					'confirmations' => $tr_data['confirmations'],
					'total_input'   => $tr_data['total_input'],
					'total_output'  => $tr_data['total_output'],
					'inputs'        => $tr_data['inputs'],
					'outputs'       => $tr_data['outputs']
				];
				$txs[] = $tx_obj;
			}
			return json_encode([
				'txs' => $txs
			]);
		}
	}
	