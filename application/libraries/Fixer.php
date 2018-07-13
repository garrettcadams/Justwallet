<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixer
{

  function get_rates($base_code, $extra_code) {

      $fields['base'] = $base_code;
			$fields['symbols'] = $extra_code;
    
      $url = "https://api.fixer.io/latest";
			$ch = curl_init();

			$url = $url . '?' . http_build_query($fields);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$response = json_decode($response, true);

			if ($httpCode == 200) {
				$live_rate = $response['rates'][''.$extra_code.''];
			} else {
				$live_rate = "0.00";
			}
    
      return $live_rate;

  }
	
	function get_btc_rates($currency, $amount) {
		
		$fields['currency'] = $currency;
		$fields['value'] = $amount;

		$url = 'https://blockchain.info/tobtc';
		$ch = curl_init();

		$url = $url . '?' . http_build_query($fields);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = json_decode($response, true);

		if ($httpCode == 200) {
			$btc_total = $response;
		} else {
			$btc_total = "undefined";
		}
		
		return $btc_total;
		
	}
	
	function get_btc_confirm_network($address) {
		
		$fields['address'] = $address;
		
		$url = 'https://blockchain.info/ru/unspent?active='.$address.'';
		$ch = curl_init();

		//$url = $url . '' . http_build_query($fields);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = json_decode($response, true);

		if ($httpCode == 200) {
			$confirm = $response['unspent_outputs'][0]['confirmations'];
		} else {
			$confirm = "undefined";
		}
		
		return $confirm;
		
	}

}

?>