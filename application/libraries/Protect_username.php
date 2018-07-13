<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Protect_username
{
  
  function check_username($username) {
    
      $forbidden_user = ['system', 'PayPal', 'Perfect Money', 'ADV Cash', 'Payeer', 'Credit card via Skrill', 'Credit card via Paygol', 'SWIFT', 'Bank of America / Local bank transfer', 'Bitcoin and other crypto-currencies', 'Blockchain', 'Credit card', 'Bitcoin', 'Skrill', 'Payza', 'admin'];
    
      if(in_array($username, $forbidden_user) !== FALSE) {
        
        return FALSE;
        
      } else {
        
        return TRUE;
        
      }

  }
  
}