<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms
{
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('settings_model');
	}
  
  function send_sms($phone, $message) {
		
	 $settings_sid = $this->CI->settings_model->get_twilio_lib(13);
	 $settings_token = $this->CI->settings_model->get_twilio_lib(14);
	 $settings_phone = $this->CI->settings_model->get_twilio_lib(15);
    
   $sid = $settings_sid['value'];
   $token = $settings_token['value'];
    
   $to = '+' . $phone . '';
   $from = '+' . $settings_phone['value'] . '';
   $body = $message;
    
   // resource url & authentication
    $uri = 'https://api.twilio.com/2010-04-01/Accounts/' . $sid . '/SMS/Messages.json';
    $auth = $sid . ':' . $token;
 
    // post string (phone number format= +15554443333 ), case matters
    $fields = 
        '&To=' .  urlencode($to) . 
        '&From=' . urlencode($from) . 
        '&Body=' . urlencode($body);
 
    // start cURL
    $res = curl_init();
     
    // set cURL options
    curl_setopt( $res, CURLOPT_URL, $uri );
    curl_setopt( $res, CURLOPT_POST, 3 ); // number of fields
    curl_setopt( $res, CURLOPT_POSTFIELDS, $fields );
    curl_setopt( $res, CURLOPT_USERPWD, $auth ); // authenticate
    curl_setopt( $res, CURLOPT_RETURNTRANSFER, true ); // don't echo
     
    // send cURL
    $response = curl_exec($res);
    $httpCode = curl_getinfo($res, CURLINFO_HTTP_CODE);
		$response = json_decode($response, true);

		if ($httpCode == 201) {
			
			$status = TRUE;
			
		} else {
			
			$status = FALSE;
			
		}
    
    return $status;
    
  }
  
}