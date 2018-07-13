<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ipn extends Public_Controller {

    /**
    * Constructor
    */
    function __construct()
    {
        
      parent::__construct();

		// load the users model
    $this->load->model('users_model');
		$this->load->model('transactions_model');
    $this->load->model('settings_model');
		$this->load->model('template_model');
		$this->load->library('currencys');
		$this->load->library('fixer');
		$this->load->library('sms');
		$this->config->set_item('csrf_protection', FALSE);
    }
  
 // Check IPN PayPal payment
 public function paypal() 
 {
		// STEP 1: read POST data
    // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
    // Instead, read raw POST data from the input stream.
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
      $keyval = explode ('=', $keyval);
      if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
    $req = 'cmd=_notify-validate';
    if (function_exists('get_magic_quotes_gpc')) {
      $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
      if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
      } else {
        $value = urlencode($value);
      }
      $req .= "&$key=$value";
    }

    // Step 2: POST IPN data back to PayPal to validate
    $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    // In wamp-like environments that do not come bundled with root authority certificates,
    // please download 'cacert.pem' from "https://curl.haxx.se/docs/caextract.html" and set
    // the directory path of the certificate as shown below:
    // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
    if ( !($res = curl_exec($ch)) ) {
      // error_log("Got " . curl_error($ch) . " when processing IPN data");
      curl_close($ch);
      exit;
    }
    curl_close($ch);
   
    // inspect IPN validation result and act accordingly
    if (strcmp ($res, "VERIFIED") == 0) {
      
      $payment_status = $_POST['payment_status'];
			$amount = $_POST['mc_gross'];
			$payment_currency = $_POST['mc_currency'];
			$txn_id = $_POST['txn_id'];
			$receiver_email = $_POST['receiver_email'];
			$payer_email = $_POST['payer_email'];
			$payment_user = $_POST['custom'];
      
      // Check user
      $user = $this->users_model->get_username($payment_user);
			
			// Check method
      $method = $this->settings_model->get_dep_method(1);
      
      // Check currency
      if ($payment_currency == $this->currencys->display->base_code) {
        $currency = "debit_base";
				$merchant_account = $method['ac_debit_base'];
      } elseif ($payment_currency == $this->currencys->display->extra1_code) {
        $currency = "debit_extra1";
				$merchant_account = $method['ac_debit_extra1'];
      } elseif ($payment_currency == $this->currencys->display->extra2_code) {
        $currency = "debit_extra2";
				$merchant_account = $method['ac_debit_extra2'];
      } elseif ($payment_currency == $this->currencys->display->extra3_code) {
        $currency = "debit_extra3";
				$merchant_account = $method['ac_debit_extra3'];
      } elseif ($payment_currency == $this->currencys->display->extra4_code) {
        $currency = "debit_extra4";
				$merchant_account = $method['ac_debit_extra4'];
      } elseif ($payment_currency == $this->currencys->display->extra5_code) {
        $currency = "debit_extra5";
				$merchant_account = $method['ac_debit_extra5'];
      } else {
        $currency = "unidentified";
				$merchant_account = $method['ac_debit_base'];
      }

			$fee = $method['fee'];
			$fee_fix = $method['fee_fix'];
      $minimum = $method['minimum_'.$currency.''];
			$maximum = $method['maximum_'.$currency.''];
      
      
      if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}
      
      // Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
      $total_amount_calc = $amount - $total_fee_calc;
      
      $label = uniqid("ppd_");
      
      // check PayPal status transactions
      if ($payment_status == "Completed") {
        
        if ($currency == "unidentified") {
           // валюта платежа неопознана
        } else {
          // check enabled currency
          if ($method[$currency] == 1) {

            // check limits
            if ($minimum >= $amount & $maximum <= $amount) {
              //лимиты не прошли
            } else {
              // check verify status
              if ($verify_status == FALSE) {
                // статус верифкации не прошел
              } else {
                // check status method
                if ($method['status'] == "1") {
                  
									// check account paypal
									if ($merchant_account == $receiver_email) {
										
										// check duplicate transaction
										$dublicate = $this->transactions_model->get_duplicate($txn_id);
										
										if ($dublicate == NULL) {
											
											// update wallet
											$wallet_total = $user[$currency] + $total_amount_calc;

											$this->users_model->update_wallet_transfer($user['username'],
												array(
													$currency => $wallet_total,
												)
											);

											// add new transaction
											$transactions = $this->transactions_model->add_transaction(array(
												"type" 				=> "1",
												"sum"  				=> $total_amount_calc,
												"fee"    			=> $total_fee_calc,
												"amount" 			=> $amount,
												"currency"		=> $currency,
												"status" 			=> "2",
												"sender" 			=> $method['name'],
												"receiver" 		=> $user['username'],
												"time"          	=> date('Y-m-d H:i:s'),
												"label" 	    => $label,
												"admin_comment" 	    => 'PayPal email payeer # '.$payer_email.'',
												"user_comment" 	    => $txn_id,
												"ip_address" 	    => "none",
												"protect" 	    => "none",
												)
											);
											
											$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}
											
										} else {
											// есть дубликат транзакции
										}
										
									} else {
										// аккаунт продавца и полученный отличаются
									}

                } else {
                  // метод не включен в админке
                }

              }

            }

          } else {
            // валюта недоступна для метода
          }
        }


      } else {
        // статус не подтвержден
      }


      
    } else if (strcmp ($res, "INVALID") == 0) {
      
      echo "The response from IPN was: <b>" .$res ."</b>";
      
    }
   
 }
	
	// Check IPN Perfect Money payment
	public function perfect_money() 
	{
		// Check method
    $method = $this->settings_model->get_dep_method(2);
		
		$alternate = strtoupper(md5($method['api_value1']));
		
		$hash_string=
			$_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
			$_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
			$_POST['PAYMENT_BATCH_NUM'].':'.
			$_POST['PAYER_ACCOUNT'].':'.$alternate.':'.
			$_POST['TIMESTAMPGMT'];
		
		$hash = strtoupper(md5($hash_string));
		
		if($hash == $_POST['V2_HASH']) {
			
			$user = $this->users_model->get_username($_POST['PAYMENT_ID']);
			
			if ($user == NULL) {
				
				// пользователь не опознан
				
			} else {
				
				$amount = $_POST['PAYMENT_AMOUNT'];
				$payment_currency = $_POST['PAYMENT_UNITS'];
				$txn_id = $_POST['PAYMENT_BATCH_NUM'];
				$payeer_account = $_POST['PAYER_ACCOUNT'];
				$receiver_account = $_POST['PAYEE_ACCOUNT'];

				// Check currency
				if ($payment_currency == $this->currencys->display->base_code) {
					$currency = "debit_base";
					$merchant_account = $method['ac_debit_base'];
				} elseif ($payment_currency == $this->currencys->display->extra1_code) {
					$currency = "debit_extra1";
					$merchant_account = $method['ac_debit_extra1'];
				} elseif ($payment_currency == $this->currencys->display->extra2_code) {
					$currency = "debit_extra2";
					$merchant_account = $method['ac_debit_extra2'];
				} elseif ($payment_currency == $this->currencys->display->extra3_code) {
					$currency = "debit_extra3";
					$merchant_account = $method['ac_debit_extra3'];
				} elseif ($payment_currency == $this->currencys->display->extra4_code) {
					$currency = "debit_extra4";
					$merchant_account = $method['ac_debit_extra4'];
				} elseif ($payment_currency == $this->currencys->display->extra5_code) {
					$currency = "debit_extra5";
					$merchant_account = $method['ac_debit_extra5'];
				} else {
					$currency = "unidentified";
					$merchant_account = $method['ac_debit_base'];
				}

				$fee = $method['fee'];
				$fee_fix = $method['fee_fix'];
				$minimum = $method['minimum_'.$currency.''];
				$maximum = $method['maximum_'.$currency.''];


				if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}

				// Calculation of the commission and total sum
				$percent = $fee/"100";
				$percent_fee = $amount * $percent;
				$total_fee_calc = $percent_fee + $fee_fix;
				$total_amount_calc = $amount - $total_fee_calc;

				$label = uniqid("pmd_");

				if ($currency == "unidentified") {
						 // валюта платежа неопознана
					} else {
						// check enabled currency
						if ($method[$currency] == 1) {

							// check limits
							if ($minimum >= $amount & $maximum <= $amount) {
								//лимиты не прошли
							} else {
								// check verify status
								if ($verify_status == FALSE) {
									// статус верифкации не прошел
								} else {
									// check status method
									if ($method['status'] == "1") {

										// check duplicate transaction
										$dublicate = $this->transactions_model->get_duplicate($txn_id);

										if ($dublicate == NULL) {

											// update wallet
											$wallet_total = $user[$currency] + $total_amount_calc;

											$this->users_model->update_wallet_transfer($user['username'],
												array(
													$currency => $wallet_total,
												)
											);

											// add new transaction
											$transactions = $this->transactions_model->add_transaction(array(
												"type" 				=> "1",
												"sum"  				=> $total_amount_calc,
												"fee"    			=> $total_fee_calc,
												"amount" 			=> $amount,
												"currency"		=> $currency,
												"status" 			=> "2",
												"sender" 			=> $method['name'],
												"receiver" 		=> $user['username'],
												"time"          	=> date('Y-m-d H:i:s'),
												"label" 	    => $label,
												"admin_comment" 	    => 'Perfect Money account payeer # '.$receiver_account.'',
												"user_comment" 	    => $txn_id,
												"ip_address" 	    => "none",
												"protect" 	    => "none",
												)
											);
											
											$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}

										} else {
											// есть дубликат транзакции
										}


									} else {
										// метод не включен в админке
									}

								}

							}

						} else {
							// валюта недоступна для метода
						}
					}
				
			}
			
			

		} else {
			
			echo "The response from IPN was: <b> NOT VALID</b>";
			
		}
		
	}
	
	// Check IPN ADV Cash payment
	public function advcash() 
	{
		// Check method
    $method = $this->settings_model->get_dep_method(3);
		
		$hash_string = $_POST['ac_transfer'].':'
			.$_POST['ac_start_date'].':'
			.$_POST['ac_sci_name'].':'
			.$_POST['ac_src_wallet'].':'
			.$_POST['ac_dest_wallet'].':'
			.$_POST['ac_order_id'].':'
			.$_POST['ac_amount'].':'
			.$_POST['ac_merchant_currency'].':'
			.$method['api_value2'];
		
		$sha256 = hash('sha256', $hash_string);
		
		if($sha256 == $_POST['ac_hash']) {
			
			$user = $this->users_model->get_username($_POST['ac_comments']);
			
			$amount = $_POST['ac_amount'];
			$payment_currency = $_POST['ac_merchant_currency'];
			$txn_id = $_POST['ac_transfer'];

			// Check currency
			if ($payment_currency == $this->currencys->display->base_code) {
				$currency = "debit_base";
				$merchant_account = $method['ac_debit_base'];
			} elseif ($payment_currency == $this->currencys->display->extra1_code) {
				$currency = "debit_extra1";
				$merchant_account = $method['ac_debit_extra1'];
			} elseif ($payment_currency == $this->currencys->display->extra2_code) {
				$currency = "debit_extra2";
				$merchant_account = $method['ac_debit_extra2'];
			} elseif ($payment_currency == $this->currencys->display->extra3_code) {
				$currency = "debit_extra3";
				$merchant_account = $method['ac_debit_extra3'];
			} elseif ($payment_currency == $this->currencys->display->extra4_code) {
				$currency = "debit_extra4";
				$merchant_account = $method['ac_debit_extra4'];
			} elseif ($payment_currency == $this->currencys->display->extra5_code) {
				$currency = "debit_extra5";
				$merchant_account = $method['ac_debit_extra5'];
			} elseif ($payment_currency == "RUR"){ // for russian ruble (code RUB)
				
				if ($this->currencys->display->base_code == "RUB") {
					$currency = "debit_base";
				} elseif ($this->currencys->display->extra1_code == "RUB") {
					$currency = "debit_extra1";
				} elseif ($this->currencys->display->extra2_code == "RUB") {
					$currency = "debit_extra2";
				} elseif ($this->currencys->display->extra3_code == "RUB") {
					$currency = "debit_extra3";
				} elseif ($this->currencys->display->extra4_code == "RUB") {
					$currency = "debit_extra4";
				} elseif ($this->currencys->display->extra5_code == "RUB") {
					$currency = "debit_extra5";
				}
				
			} else {
				$currency = "unidentified";
				$merchant_account = $method['ac_debit_base'];
			}

			$fee = $method['fee'];
			$fee_fix = $method['fee_fix'];
			$minimum = $method['minimum_'.$currency.''];
			$maximum = $method['maximum_'.$currency.''];


			if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}

			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_amount_calc = $amount - $total_fee_calc;

			$label = uniqid("acd_");
			
			if ($currency == "unidentified") {
           // валюта платежа неопознана
        } else {
				
				if ($_POST['ac_transaction_status'] == "COMPLETED") {
					
					// check enabled currency
          if ($method[$currency] == 1) {

            // check limits
           if ($minimum > $amount & $maximum < $amount) {
              //лимиты не прошли
           } else {
              // check verify status
              if ($verify_status == FALSE) {
                // статус верифкации не прошел
              } else {
                // check status method
                if ($method['status'] == "1") {
									
									// check duplicate transaction
									$dublicate = $this->transactions_model->get_duplicate($txn_id);

									if ($dublicate == NULL) {
									
										// update wallet
										$wallet_total = $user[$currency] + $total_amount_calc;

										$this->users_model->update_wallet_transfer($user['username'],
											array(
												$currency => $wallet_total,
											)
										);
										
										// add new transaction
										$transactions = $this->transactions_model->add_transaction(array(
											"type" 				=> "1",
											"sum"  				=> $total_amount_calc,
											"fee"    			=> $total_fee_calc,
											"amount" 			=> $amount,
											"currency"		=> $currency,
											"status" 			=> "2",
											"sender" 			=> $method['name'],
											"receiver" 		=> $user['username'],
											"time"          	=> date('Y-m-d H:i:s'),
											"label" 	    => $label,
											"admin_comment" 	    => 'ADV Cash account payeer # '.$_POST['ac_src_wallet'].'',
											"user_comment" 	    => $txn_id,
											"ip_address" 	    => "none",
											"protect" 	    => "none",
											)
										);
										
										$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}
										
									} else {
										// есть дубликат транзакции
									}


                } else {
                  // метод не включен в админке
                }

              }

           }

          } else {
            // валюта недоступна для метода
          }
					
				} else {
					// транзакция не выполнена
				}
					
          
        }
			
		} else {
			
			echo "The response from IPN was: <b> NOT VALID</b>";
			// хэш не совпал - платеж недостоверен
		}
		
	}
	
	// Check IPN Payeer payment
	public function payeer() 
	{
		
		if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))) return;
		
		// Check method
    $method = $this->settings_model->get_dep_method(4);
		
		if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
		{
			
			$m_key = $method['api_value1'];

			$arHash = array(
				$_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status']
			);

			if (isset($_POST['m_params']))
			{
				$arHash[] = $_POST['m_params'];
			}

			$arHash[] = $m_key;

			$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

			if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
			{
				
				$amount = $_POST['m_amount'];
				$payment_currency = $_POST['m_curr'];
				$txn_id = $_POST['m_operation_id'];
				$receiver_account = $_POST['m_shop'];
				$payeer_user = base64_decode($_POST['m_desc']);
				
				$user = $this->users_model->get_username($payeer_user);

				// Check currency
				if ($payment_currency == $this->currencys->display->base_code) {
					$currency = "debit_base";
					$merchant_account = $method['ac_debit_base'];
				} elseif ($payment_currency == $this->currencys->display->extra1_code) {
					$currency = "debit_extra1";
					$merchant_account = $method['ac_debit_extra1'];
				} elseif ($payment_currency == $this->currencys->display->extra2_code) {
					$currency = "debit_extra2";
					$merchant_account = $method['ac_debit_extra2'];
				} elseif ($payment_currency == $this->currencys->display->extra3_code) {
					$currency = "debit_extra3";
					$merchant_account = $method['ac_debit_extra3'];
				} elseif ($payment_currency == $this->currencys->display->extra4_code) {
					$currency = "debit_extra4";
					$merchant_account = $method['ac_debit_extra4'];
				} elseif ($payment_currency == $this->currencys->display->extra5_code) {
					$currency = "debit_extra5";
					$merchant_account = $method['ac_debit_extra5'];
				} else {
					$currency = "unidentified";
					$merchant_account = $method['ac_debit_base'];
				}

				$fee = $method['fee'];
				$fee_fix = $method['fee_fix'];
				$minimum = $method['minimum_'.$currency.''];
				$maximum = $method['maximum_'.$currency.''];


				if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}

				// Calculation of the commission and total sum
				$percent = $fee/"100";
				$percent_fee = $amount * $percent;
				$total_fee_calc = $percent_fee + $fee_fix;
				$total_amount_calc = $amount - $total_fee_calc;

				$label = uniqid("pyd_");
				
				if ($currency == "unidentified") {
           // валюта платежа неопознана
					 echo $_POST['m_orderid'].'|success';
        } else {
          // check enabled currency
          if ($method[$currency] == 1) {

            // check limits
            if ($minimum > $amount & $maximum < $amount) {
              //лимиты не прошли
							echo $_POST['m_orderid'].'|success';
							
            } else {
              // check verify status
              if ($verify_status == FALSE) {
                // статус верифкации не прошел
								echo $_POST['m_orderid'].'|success';
								
              } else {
                // check status method
                if ($method['status'] == "1") {
									
									// check duplicate transaction
									$dublicate = $this->transactions_model->get_duplicate($txn_id);

									if ($dublicate == NULL) {
										
										// update wallet
										$wallet_total = $user[$currency] + $total_amount_calc;

										$this->users_model->update_wallet_transfer($user['username'],
											array(
												$currency => $wallet_total,
											)
										);
										
										// add new transaction
										$transactions = $this->transactions_model->add_transaction(array(
											"type" 				=> "1",
											"sum"  				=> $total_amount_calc,
											"fee"    			=> $total_fee_calc,
											"amount" 			=> $amount,
											"currency"		=> $currency,
											"status" 			=> "2",
											"sender" 			=> $method['name'],
											"receiver" 		=> $user['username'],
											"time"          	=> date('Y-m-d H:i:s'),
											"label" 	    => $label,
											"admin_comment" 	    => 'Payeer method payment order - '.$_POST['m_operation_ps'].'',
											"user_comment" 	    => $txn_id,
											"ip_address" 	    => "none",
											"protect" 	    => "none",
											)
										);
										
										echo $_POST['m_orderid'].'|success';
										
										$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}
										
										
									} else {
										// есть дубликат транзакции
										echo $_POST['m_orderid'].'|success';
										
									}


                } else {
                  // метод не включен в админке
									echo $_POST['m_orderid'].'|success';
									
                }

              }

            }

          } else {
						echo $_POST['m_orderid'].'|success';
            // валюта недоступна для метода
          }
        }
			} else {
				
				// хэш не совпал или операция не выполнена на стороне Payeer
				echo $_POST['m_orderid'].'|error';
				
			}

		} else {
			
			// сигнатура не получена или не получен ID операции
			echo $_POST['m_orderid'].'|error';
			
		}
		
	}
	
	// Check IPN Skrill payment
	public function skrill() 
	{
		// Check method
    $method = $this->settings_model->get_dep_method(5);
		
		if (isset($_POST['mb_transaction_id']) && isset($_POST['md5sig']))
		{
			
			// Validate the Moneybookers signature
			$hash_string = $_POST['merchant_id']
				.$_POST['transaction_id']
				.strtoupper(md5($method['api_value2']))
				.$_POST['mb_amount']
				.$_POST['mb_currency']
				.$_POST['status'];

			$hash = strtoupper(md5($hash_string));
			
			$amount = $_POST['mb_amount'];
			$payment_currency = $_POST['mb_currency'];
			$txn_id = $_POST['mb_transaction_id'];
			$receiver_account = $_POST['pay_to_email'];
			$payeer_user = $_POST['pay_from_email'];
			
			$user = $this->users_model->get_username($_POST['Field1']);

			// Check currency
			if ($payment_currency == $this->currencys->display->base_code) {
				$currency = "debit_base";
				$merchant_account = $method['ac_debit_base'];
			} elseif ($payment_currency == $this->currencys->display->extra1_code) {
				$currency = "debit_extra1";
				$merchant_account = $method['ac_debit_extra1'];
			} elseif ($payment_currency == $this->currencys->display->extra2_code) {
				$currency = "debit_extra2";
				$merchant_account = $method['ac_debit_extra2'];
			} elseif ($payment_currency == $this->currencys->display->extra3_code) {
				$currency = "debit_extra3";
				$merchant_account = $method['ac_debit_extra3'];
			} elseif ($payment_currency == $this->currencys->display->extra4_code) {
				$currency = "debit_extra4";
				$merchant_account = $method['ac_debit_extra4'];
			} elseif ($payment_currency == $this->currencys->display->extra5_code) {
				$currency = "debit_extra5";
				$merchant_account = $method['ac_debit_extra5'];
			} else {
				$currency = "unidentified";
				$merchant_account = $method['ac_debit_base'];
			}

			$fee = $method['fee'];
			$fee_fix = $method['fee_fix'];
			$minimum = $method['minimum_'.$currency.''];
			$maximum = $method['maximum_'.$currency.''];


			if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}

			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_amount_calc = $amount - $total_fee_calc;

			$label = uniqid("skl_");
			
			if ($currency == "unidentified") {
           // валюта платежа неопознана
        } else {
          // check enabled currency
          if ($method[$currency] == 1) {

            // check limits
            if ($minimum > $amount & $maximum < $amount) {
              //лимиты не прошли
            } else {
              // check verify status
              if ($verify_status == FALSE) {
                // статус верифкации не прошел
              } else {
                // check status method
                if ($method['status'] == "1") {
									
										// check duplicate transaction
										$dublicate = $this->transactions_model->get_duplicate($txn_id);

										if ($dublicate == NULL) {
											
											if ($_POST['status'] == "2" && $receiver_account == $merchant_account) {
												
												// update wallet
												$wallet_total = $user[$currency] + $total_amount_calc;

												$this->users_model->update_wallet_transfer($user['username'],
													array(
														$currency => $wallet_total,
													)
												);

												// add new transaction
												$transactions = $this->transactions_model->add_transaction(array(
													"type" 				=> "1",
													"sum"  				=> $total_amount_calc,
													"fee"    			=> $total_fee_calc,
													"amount" 			=> $amount,
													"currency"		=> $currency,
													"status" 			=> "2",
													"sender" 			=> $method['name'],
													"receiver" 		=> $user['username'],
													"time"          	=> date('Y-m-d H:i:s'),
													"label" 	    => $label,
													"admin_comment" 	    => 'Payeer email - '.$payeer_user.'',
													"user_comment" 	    => $txn_id,
													"ip_address" 	    => "none",
													"protect" 	    => "none",
													)
												);
												
												$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}
												
											} else {
												// статус не выполнен в системе Skrillили аккаунт мерчанта не совпадает
											}
											
										} else {
											// есть дубликат транзакции
										}

                } else {
                  // метод не включен в админке
                }

              }

            }

          } else {
            // валюта недоступна для метода
          }
        }
			
		} else {
			// не получен id транзакции или сигнатура
		}
		
	}
	
	// Check IPN Paygol payment
	public function paygol() 
	{
		// Check method
    $method = $this->settings_model->get_dep_method(6);

		$secret_key = $method['api_value1'];  // Enter secret key for your service. 
		// Secret key validation 
		if ($secret_key == $_GET['key']) {
			
			$amount = $_GET['frmprice'];
			$payment_currency = $_GET['frmcurrency'];
			$txn_id = $_GET['transaction_id'];
			
			$user = $this->users_model->get_username($_GET['custom']);
			
			// Check currency
			if ($payment_currency == $this->currencys->display->base_code) {
				$currency = "debit_base";
				$merchant_account = $method['ac_debit_base'];
			} elseif ($payment_currency == $this->currencys->display->extra1_code) {
				$currency = "debit_extra1";
				$merchant_account = $method['ac_debit_extra1'];
			} elseif ($payment_currency == $this->currencys->display->extra2_code) {
				$currency = "debit_extra2";
				$merchant_account = $method['ac_debit_extra2'];
			} elseif ($payment_currency == $this->currencys->display->extra3_code) {
				$currency = "debit_extra3";
				$merchant_account = $method['ac_debit_extra3'];
			} elseif ($payment_currency == $this->currencys->display->extra4_code) {
				$currency = "debit_extra4";
				$merchant_account = $method['ac_debit_extra4'];
			} elseif ($payment_currency == $this->currencys->display->extra5_code) {
				$currency = "debit_extra5";
				$merchant_account = $method['ac_debit_extra5'];
			} else {
				$currency = "unidentified";
				$merchant_account = $method['ac_debit_base'];
			}

			$fee = $method['fee'];
			$fee_fix = $method['fee_fix'];
			$minimum = $method['minimum_'.$currency.''];
			$maximum = $method['maximum_'.$currency.''];


			if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}

			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_amount_calc = $amount - $total_fee_calc;

			$label = uniqid("pgd_");
			
			if ($currency == "unidentified") {
           // валюта платежа неопознана
        } else {
          // check enabled currency
          if ($method[$currency] == 1) {

            // check limits
            if ($minimum > $amount & $maximum < $amount) {
              //лимиты не прошли
            } else {
              // check verify status
              if ($verify_status == FALSE) {
                // статус верифкации не прошел
              } else {
                // check status method
                if ($method['status'] == "1") {
									
									// check duplicate transaction
									$dublicate = $this->transactions_model->get_duplicate($txn_id);

									if ($dublicate == NULL) {
										
										// update wallet
										$wallet_total = $user[$currency] + $total_amount_calc;

										$this->users_model->update_wallet_transfer($user['username'],
										array(
											$currency => $wallet_total,
											)
										);

										// add new transaction
										$transactions = $this->transactions_model->add_transaction(array(
											"type" 				=> "1",
											"sum"  				=> $total_amount_calc,
											"fee"    			=> $total_fee_calc,
											"amount" 			=> $amount,
											"currency"		=> $currency,
											"status" 			=> "2",
											"sender" 			=> $method['name'],
											"receiver" 		=> $user['username'],
											"time"          	=> date('Y-m-d H:i:s'),
											"label" 	    => $label,
											"admin_comment" 	    => "none",
											"user_comment" 	    => $txn_id,
											"ip_address" 	    => "none",
											"protect" 	    => "none",
											)
										);
										
										$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}
										
									} else {
										
										// есть дубликат транзакции
									}

                } else {
                  // метод не включен в админке
                }

              }

            }

          } else {
            // валюта недоступна для метода
          }
        }
				
		} else {
			
			// ключ не достоверен
			
		}
		
		
		
	}
	
	// Check IPN Coinpayments payment
	public function coinpayments() 
	{
		// Check method
    $method = $this->settings_model->get_dep_method(9);
		
		// Check account for receive money
		$secret = $method['api_value1'];

		$request = file_get_contents('php://input');
		if ($request === FALSE || empty($request)) {
			die("Error reading POST data");
		}
		
		$hmac = hash_hmac("sha512", $request, $secret);
		
		if ($hmac == $_SERVER['HTTP_HMAC']) {
			
			$amount = $_POST['amount1'];
			$payment_currency = $_POST['currency1'];
			$txn_id = $_POST['txn_id'];
			
			$user = $this->users_model->get_username($_POST['custom']);
			
			// Check currency
			if ($payment_currency == $this->currencys->display->base_code) {
				$currency = "debit_base";
				$merchant_account = $method['ac_debit_base'];
			} elseif ($payment_currency == $this->currencys->display->extra1_code) {
				$currency = "debit_extra1";
				$merchant_account = $method['ac_debit_extra1'];
			} elseif ($payment_currency == $this->currencys->display->extra2_code) {
				$currency = "debit_extra2";
				$merchant_account = $method['ac_debit_extra2'];
			} elseif ($payment_currency == $this->currencys->display->extra3_code) {
				$currency = "debit_extra3";
				$merchant_account = $method['ac_debit_extra3'];
			} elseif ($payment_currency == $this->currencys->display->extra4_code) {
				$currency = "debit_extra4";
				$merchant_account = $method['ac_debit_extra4'];
			} elseif ($payment_currency == $this->currencys->display->extra5_code) {
				$currency = "debit_extra5";
				$merchant_account = $method['ac_debit_extra5'];
			} else {
				$currency = "unidentified";
				$merchant_account = $method['ac_debit_base'];
			}
			
			$fee = $method['fee'];
			$fee_fix = $method['fee_fix'];
			$minimum = $method['minimum_'.$currency.''];
			$maximum = $method['maximum_'.$currency.''];


			if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}

			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_amount_calc = $amount - $total_fee_calc;

			$label = uniqid("cpb_");
			
			if ($merchant_account == $_POST['merchant']) {
				
				if($_POST['status'] == "100") {
					
					if ($currency == "unidentified") {
           // валюта платежа неопознана
					} else {
						// check enabled currency
						if ($method[$currency] == 1) {

							// check limits
							if ($minimum > $amount & $maximum < $amount) {
								//лимиты не прошли
							} else {
								// check verify status
								if ($verify_status == FALSE) {
									// статус верифкации не прошел
								} else {
									// check status method
									if ($method['status'] == "1") {
										
										// check duplicate transaction
										$dublicate = $this->transactions_model->get_duplicate($txn_id);

										if ($dublicate == NULL) {

											// update wallet
											$wallet_total = $user[$currency] + $total_amount_calc;

											$this->users_model->update_wallet_transfer($user['username'],
											array(
												$currency => $wallet_total,
												)
											);

											// add new transaction
											$transactions = $this->transactions_model->add_transaction(array(
												"type" 				=> "1",
												"sum"  				=> $total_amount_calc,
												"fee"    			=> $total_fee_calc,
												"amount" 			=> $amount,
												"currency"		=> $currency,
												"status" 			=> "2",
												"sender" 			=> $method['name'],
												"receiver" 		=> $user['username'],
												"time"          	=> date('Y-m-d H:i:s'),
												"label" 	    => $label,
												"admin_comment" 	    => ''.$_POST['amount'].' '.$_POST['currency'].' received. Confirms - '.$_POST['confirms'].'',
												"user_comment" 	    => $txn_id,
												"ip_address" 	    => "none",
												"protect" 	    => "none",
												)
											);
											
											$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}

										} else {

											// есть дубликат транзакции

										}

									} else {
										// метод не включен в админке
										
										
									}

								}

							}

						} else {
							// валюта недоступна для метода
							
							// add new transaction
						}
					}
					
				} else {
					// статус не выполнен
					
				}
				
			} else {
				// мерчант не совпал
				
			}
			
			
		} else {
			
			die("HMAC signature does not match");
			
		}
		
	}
	
	// Check IPN Blockchain payment
	public function blockchain() 
	{
		// Check method
    $method = $this->settings_model->get_dep_method(10);
		
		if ($_GET['secret'] == $method['api_value2']) {
			
			$transaction_hash = $_GET['transaction_hash'];
			$value_in_satoshi = $_GET['value'];
			$value_in_btc = $value_in_satoshi / 100000000;
			$address = $_GET['address'];
			$block_transaction = $this->transactions_model->get_chain($address);
			$currency = $block_transaction['currency'];
			
			// check username
			$user = $this->users_model->get_username($block_transaction['receiver']);
			
			// check currency transaction
			if ($currency == "debit_base") {
				$payment_currency= $this->currencys->display->base_code;
				$merchant_account = $method['ac_debit_base'];
			} elseif ($currency == "debit_extra1") {
				$payment_currency = $this->currencys->display->extra1_code;
				$merchant_account = $method['ac_debit_extra1'];
			} elseif ($currency == "debit_extra2") {
				$payment_currency = $this->currencys->display->extra2_code;
				$merchant_account = $method['ac_debit_extra2'];
			} elseif ($currency == "debit_extra3") {
				$payment_currency = $this->currencys->display->extra3_code;
				$merchant_account = $method['ac_debit_extra3'];
			} elseif ($currency =="debit_extra4") {
				$payment_currency = $this->currencys->display->extra4_code;
				$merchant_account = $method['ac_debit_extra4'];
			} elseif ($currency =="debit_extra5") {
				$payment_currency = $this->currencys->display->extra5_code;
				$merchant_account = $method['ac_debit_extra5'];
			}
			
			// check rate BTC and amount in currency tarnsaction
			$rate = $this->fixer->get_btc_rates($payment_currency, "1");
			$amount = $value_in_btc/$rate;
			
			$fee = $method['fee'];
			$fee_fix = $method['fee_fix'];
			$minimum = $method['minimum_'.$currency.''];
			$maximum = $method['maximum_'.$currency.''];


			if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}

			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_amount_calc = $amount - $total_fee_calc;
			
			if ($_GET['confirmations'] == 6) {
				
				// update transaction history
				$this->transactions_model->update_btc_transactions($block_transaction['id'],
					array(
						"status"   			 => "2",
						"admin_comment"  => $_GET['secret'],
						"amount"         => $amount,
						"sum"  				 	 => $total_amount_calc,
					)
				);

				// update wallet
				$wallet_total = $user[$currency] + $total_amount_calc;

				$this->users_model->update_wallet_transfer($block_transaction['receiver'],
					array(
						$currency => $wallet_total,
					)
				);
				
				echo '*ok*';
				
				$mail_amount = number_format($total_amount_calc, 2, '.', '');
											
											$email_template = $this->template_model->get_email_template(9);
											
											if($email_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												// variables to replace
												$site_name = $this->settings->site_name;
												$site_link  = base_url('account/dashboard');
												$name_user = $user['first_name'] . ' ' . $user['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user['email']);
												$this -> email -> subject($email_template['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template = $this->template_model->get_sms_template(20);
							
											if($sms_template['status'] == "1") {
												
												// Check currency
												if ($currency == "debit_base") {
													$symbol = $this->currencys->display->base_code;
												} elseif ($currency == "debit_extra1") {
													$symbol = $this->currencys->display->extra1_code;
												} elseif ($currency == "debit_extra2") {
													$symbol = $this->currencys->display->extra2_code;
												} elseif ($currency == "debit_extra3") {
													$symbol = $this->currencys->display->extra3_code;
												} elseif ($currency =="debit_extra4") {
													$symbol = $this->currencys->display->extra4_code;
												} elseif ($currency =="debit_extra5") {
													$symbol = $this->currencys->display->extra5_code;
												}

												$rawstring = $sms_template['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user['phone'], $str_1);

											}
				
			} else {
				
				// получено меньше 6 подтверждений
				
			}
			
		} else {
			
			// секрет не получен или проверка не пройдена
			
		}
		
	}

}