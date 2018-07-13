<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice
{

  function sum_tickets() {

      $CI =& get_instance();

      $CI->load->model('support_model');
    
      $tickets = $CI->load->support_model->sum_tickets("0");
    
      return $tickets;

  }
  
  function sum_verification() {

      $CI =& get_instance();

      $CI->load->model('verification_model');
    
      $verification = $CI->load->verification_model->sum_verification("0");
    
      return $verification;

  }
	
	// ** Admin notice ** //
  
  function sum_admin_support() {

      $CI =& get_instance();

      $CI->load->model('support_model');
    
      $ticket_pending = $CI->load->support_model->sum_admin_support();
    
      return $ticket_pending;

  }
	
	// ** Admin notice ** //
  
  function sum_admin_disputes() {

      $CI =& get_instance();

      $CI->load->model('disputes_model');
    
      $disputes_pending = $CI->load->disputes_model->sum_admin_disputes();
    
      return $disputes_pending;

  }
	
	// ** Admin notice ** //
  
  function sum_admin_verify() {

      $CI =& get_instance();

      $CI->load->model('verification_model');
    
      $verify_pending = $CI->load->verification_model->sum_admin_verify();
    
      return $verify_pending;

  }
  
  // ** User notice ** //
  
  function sum_user_invoices($user) {

      $CI =& get_instance();

      $CI->load->model('invoices_model');
    
      $invoices_pending = $CI->load->invoices_model->sum_user_invoices($user);
    
      return $invoices_pending;

  }
	
	// ** User notice support ** //
  
  function sum_user_support($user) {

      $CI =& get_instance();

      $CI->load->model('support_model');
    
      $ticket_pending = $CI->load->support_model->sum_user_support($user);
    
      return $ticket_pending;

  }
  
  // ** Total merchants ** //
  
  function sum_merchants($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $total_merchants = $CI->load->merchants_model->sum_total_merchants($id);
    
      return $total_merchants;

  }
  
  // ** Total items ** //
  
  function sum_items($merchant_id, $category_id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $total_items = $CI->load->merchants_model->sum_total_items($merchant_id, $category_id);
    
      return $total_items;

  }
  
  // ** Total items in orders ** //
  
  function sum_items_orders($user) {

      $CI =& get_instance();

      $CI->load->model('orders_model');
    
      $total_items = $CI->load->orders_model->sum_total_orders($user);
    
      return $total_items;

  }
  
  // ** Total items in cart ** //
  
  function sum_items_cart($user) {

      $CI =& get_instance();

      $CI->load->model('cart_model');
    
      $total_items = $CI->load->cart_model->sum_total_items($user);
    
      return $total_items;

  }
  
  // ** Detail img item cart ** //
  
  function detail_item_cart_img($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['img'];

  }
  
  // ** Detail name item cart ** //
  
  function detail_item_cart_name($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['name'];

  }
  
  // ** Detail id item cart ** //
  
  function detail_item_cart_id($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['id'];

  }
  
  // ** Detail id item fee ** //
  
  function detail_item_cart_fee($id, $amount) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      $merchant = $CI->load->merchants_model->get_merchant($item['merchant_id']);
    
      // Who pays the fees?
		  if ($merchant['payeer_fee'] == "0") {
        
        return "0.00";
        
      } else {
        
        // Calculation of the commission and total sum
        $percent = $merchant['fee']/"100";
        $percent_fee = $amount * $percent;
        $total_fee_calc = $percent_fee + $merchant['fix_fee'];
        $total_fee = number_format($total_fee_calc, 2, '.', '');
        
        return $total_fee;
        
      }

  }
  
  // ** Detail availability item cart ** //
  
  function detail_item_cart_availability($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['availability'];

  }
  
  // ** Detail link item cart ** //
  
  function detail_item_cart_link($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['download_link'];

  }
  
  // ** Detail currency item cart ** //
  
  function detail_item_cart_currency($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['currency'];

  }
  
  // ** Detail price item cart ** //
  
  function detail_item_cart_price($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_item($id);
    
      return $item['price'];

  }
  
  // ** Detail shop item cart ** //
  
  function detail_item_cart_shop($id) {

      $CI =& get_instance();

      $CI->load->model('merchants_model');
    
      $item = $CI->load->merchants_model->get_cart_shop_item($id);
    
      return $item['name'];

  }
  
  // ** Hold balance ** //
  
  function hold_balance($user, $currency, $type) 
  {

      $CI =& get_instance();
      
      $CI->load->model('users_model');
      $CI->load->model('transactions_model');
      
      // Main balance
      if ($type == 1) {
        
        $user_holder = $CI->load->users_model->get_username($user);
        
        // hold balance
        $hold_balance = $CI->load->transactions_model->hold_balance($user, $currency);
        
        // check balance - hold
    
        if ($hold_balance == NULL) {

          return $user_holder[$currency];

        } else {
          
          $total_balance = $user_holder[$currency] - $hold_balance;

          return number_format($total_balance, 2, '.', '');

        }
        
        
      } else {
        
        // hold balance
        $hold_balance = $CI->load->transactions_model->hold_balance($user, $currency);
    
        if ($hold_balance == NULL) {

          return "0.00";

        } else {

          return $hold_balance;

        }
        
      }

  }
  
  // ** Check +/- amount and fee transactions for merchant for transaction ** //
  
  function check_amount_transaction($sum, $amount, $fee, $sender, $receiver, $type, $user, $id_transaction) {
    
    $CI =& get_instance();
      
    $CI->load->model('users_model');
    $CI->load->model('transactions_model');
    
    // Money transfer
    if ($type == 3) {
      
      if ($sender == $user) {
        
        return '<span class="text-danger">- '.$sum.'</span>';
        
      } else {
        
        return '<span class="text-success">+ '.$amount.'</span>';
        
      }
      
    } else if ($type == 1) {

      return '<span class="text-success">+ '.$sum.'</span>';
      
    } else if ($type == 4) {
      
      return '<span class="text-danger">- '.$sum.'</span>';
      
    } else if ($type == 2) {
      
      return '<span class="text-danger">- '.$sum.'</span>';
      
    } else if ($type == 5) {
      
      $transaction = $CI->load->transactions_model->get_transactions($id_transaction);
      
      $sum_mecrhant = $amount - $fee;
      
      // Merchant fee
      if ($transaction['payer_fee'] == 1) {
        
        // for user/sender
        if ($sender == $user) {
          
          return '<span class="text-danger">- '.$amount.'</span>';
          
        } else {
          
          return '<span class="text-success">+ '.number_format($sum_mecrhant, 2, '.', '').'</span>';
          
        }
        
      } else {
        
         // Payer fee
        
         if ($sender == $user) {
           
           return '<span class="text-danger">- '.$sum.'</span>';
           
         } else {
           
           return '<span class="text-success">+ '.$amount.'</span>';
           
         }
        
      }
      
    }
    
  }
  
  // ** Check detail transaction ** //
  
  function check_fee_transaction($sum, $amount, $fee, $sender, $receiver, $type, $user, $id_transaction) {
    
    $CI =& get_instance();
      
    $CI->load->model('users_model');
    $CI->load->model('transactions_model');
    
    if ($type == 1) {
      
      return $fee;
      
    } else if ($type == 2) {
      
      return $fee;
      
    } else if ($type == 3) {
      
      if ($sender == $user) {
        
        return $fee;
        
      } else {
        
        return "0.00";
        
      }
      
    } else if ($type == 4) {
      
      return $fee;
      
    } else if ($type == 5) {
      
      $transaction = $CI->load->transactions_model->get_transactions($id_transaction);
      
      // Merchant fee
      if ($transaction['payer_fee'] == 1) {
        
        // for user/sender
        if ($sender == $user) {
          
          return "0.00";
          
        } else {
          
          return $fee;
          
        }
        
      } else {
        
         // Payer fee
        
         if ($sender == $user) {
           
           return $fee;
           
         } else {
           
           return "0.00";
           
         }
        
      }
      
    }
    
  }
  
  // ** Check detail sum transaction ** //
  
  function check_sum_transaction($sum, $amount, $fee, $sender, $receiver, $type, $user, $id_transaction) {
    
    $CI =& get_instance();
      
    $CI->load->model('users_model');
    $CI->load->model('transactions_model');
    
    if ($type == 1) {
      
      return $sum;
      
    } else if ($type == 2) {
      
      return $amount;
      
    } else if ($type == 3) {
      
      if ($sender == $user) {
        
        return $sum;
        
      } else {
        
        return $amount;
        
      }
      
    } else if ($type == 4) {
      
      return $sum;
      
    } else if ($type == 5) {
      
    }
    
  }
  
  // ** Check img for transactions ** //
  
  function check_img($type, $sender, $id) {
    
    $CI =& get_instance();

    $CI->load->model('users_model');
    $CI->load->model('transactions_model');
    $CI->load->model('merchants_model');
    $CI->load->model('settings_model');
    
    if ($type == 3) {
      
        $user = $CI->load->users_model->get_username($sender);
      
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $user['email'] ) ) );
        if ( $img ) {
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
        }
      
        return $url;
      
    } else if ($type == 1) {
      
        $method = $CI->load->settings_model->get_dep_method_name($sender);
      
        if ($method != NULL) {
          
          if ($method['id'] == 1) {
            
            return "/assets/themes/account/img/pay-icon/paypal.png";
            
          } else if ($method['id'] == 2) {
            
            return "/assets/themes/account/img/pay-icon/pm.png";
            
          } else if ($method['id'] == 3) {
            
            return "/assets/themes/account/img/pay-icon/advcash.png";
            
          } else if ($method['id'] == 4) {
            
            return "/assets/themes/account/img/pay-icon/payeer.png";
            
          } else if ($method['id'] == 5) {
            
            return "/assets/themes/account/img/pay-icon/visa.png";
            
          } else if ($method['id'] == 6) {
            
            return "/assets/themes/account/img/pay-icon/visa.png";
            
          } else if ($method['id'] == 7) {
            
            return "/assets/themes/account/img/pay-icon/swift.png";
            
          } else if ($method['id'] == 8) {
            
            return "/assets/themes/account/img/pay-icon/local_bank.png";
            
          } else if ($method['id'] == 9) {
            
            return "/assets/themes/account/img/pay-icon/btc.png";
            
          } else if ($method['id'] == 10) {
            
            return "/assets/themes/account/img/pay-icon/blockchain.png";
            
          } else {
            
            return "/assets/themes/account/img/pay-icon/fiat.png";
            
          }
          
        } else {
          
          return "/assets/themes/account/img/pay-icon/fiat.png";
          
        }
        
    } else if ($type == 4) {
      
      return "/assets/themes/account/img/pay-icon/exchange.png";
      
    }  else if ($type == 2) {
      
      $transaction = $CI->load->transactions_model->get_transactions($id);
      
      $method_win = $CI->load->settings_model->get_win_method_name($transaction['user_comment']);
      
      if ($method_win != NULL) {
        
        if ($method['id'] == 1) {
          
          return "/assets/themes/account/img/pay-icon/paypal.png";
          
        } else if ($method_win['id'] == 2) {
          
          return "/assets/themes/account/img/pay-icon/visa.png";
          
        } else if ($method_win['id'] == 3) {
          
          return "/assets/themes/account/img/pay-icon/btc.png";
          
        } else if ($method_win['id'] == 4) {
          
          return "/assets/themes/account/img/pay-icon/swift.png";
          
        } else if ($method_win['id'] == 5) {
          
          return "/assets/themes/account/img/pay-icon/skrill.png";
          
        } else if ($method_win['id'] == 6) {
          
          return "/assets/themes/account/img/pay-icon/payza.png";
          
        } else if ($method_win['id'] == 7) {
          
          return "/assets/themes/account/img/pay-icon/advcash.png";
          
        } else if ($method_win['id'] == 8) {
          
          return "/assets/themes/account/img/pay-icon/pm.png";
          
        } else {
          
          return "/assets/themes/account/img/pay-icon/fiat.png";
          
        }
        
      } else {
        
        return "/assets/themes/account/img/pay-icon/fiat.png";
        
      }
      
    } else if ($type == 5) {
      
      $transaction = $CI->load->transactions_model->get_transactions($id);
      
      $check_merchant = $CI->load->transactions_model->get_merchant($transaction['merchant']);
      
      if ($check_merchant != NULL) {
        
        return '/upload/logo/'.$check_merchant['logo'];
        
      } else {
        
        return "/assets/themes/account/img/pay-icon/fiat.png";
        
      }
      
    }

  }
  
  // ** Send email notification ** //
  
  
}

?>