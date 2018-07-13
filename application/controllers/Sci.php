<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sci extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
      
        // load the language files
        $this->lang->load('users');
        
        // load the users model
        $this->load->model('users_model');
        $this->load->model('transactions_model');
        $this->load->model('settings_model');
				$this->load->model('merchants_model');
				$this->load->model('template_model');
        $this->load->library('currencys');
        $this->load->library('fixer');
				$this->load->library('sms');
				$this->load->helper('captcha');
        $this->config->set_item('csrf_protection', FALSE);
    }
  
  
   /**
	 * POST form
     */
	function form()
	{
				$this->form_validation->set_rules('merchant', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
				$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[1]');
				$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
				$this->form_validation->set_rules('item_name', lang('users transfer amount'), 'required|trim|min_length[3]|max_length[100]');
				$this->form_validation->set_rules('custom', lang('users transfer amount'), 'required|trim|max_length[100]');
		
				if ($this->form_validation->run() == FALSE)
				{

					$this->session->set_flashdata('error', lang('users sci fail_form'));
					redirect(site_url("developers"));

				} else {
				
					$id_merchant = $this->input->post("merchant");
					$amount = number_format($this->input->post("amount"), 2, '.', '');
					$currency_code = $this->input->post("currency");
					$item_name = $this->input->post("item_name");
					$custom = $this->input->post("custom");
					
					$merchant = $this->merchants_model->get_sci_merchant($id_merchant);
					
					if ($merchant == NULL) {
						
						$this->session->set_flashdata('error', lang('users sci fail_merch'));
						redirect(site_url("developers"));
						
					} else {
						
						// Check currency and account for receiving deposits
						if ($currency_code == "debit_base") {
							$symbol = $this->currencys->display->base_code;
						} elseif ($currency_code == "debit_extra1") {
							$symbol = $this->currencys->display->extra1_code;
						} elseif ($currency_code == "debit_extra2") {
							$symbol = $this->currencys->display->extra2_code;
						} elseif ($currency_code == "debit_extra3") {
							$symbol = $this->currencys->display->extra3_code;
						} elseif ($currency_code =="debit_extra4") {
							$symbol = $this->currencys->display->extra4_code;
						} elseif ($currency_code =="debit_extra5") {
							$symbol = $this->currencys->display->extra5_code;
						}
						// Check currency and account for receiving deposits
						
						// Who pays the fees?
						if ($merchant['payeer_fee'] == "1") {
							
							// Calculation of the commission and total sum
							$percent = $merchant['fee']/"100";
							$percent_fee = $amount * $percent;
							$total_fee_calc = $percent_fee + $merchant['fix_fee'];
							$total_fee = number_format($total_fee_calc, 2, '.', '');
							$total_amount_calc = $amount + $total_fee;
							$total_amount = number_format($total_amount_calc, 2, '.', '');
							
						} else {
							
							$total_amount = number_format($amount, 2, '.', '');
							$total_fee = '0.00';
							
						}
						
					}
					
				}
		
        // setup page header data
        $this->set_title(sprintf(lang('users merchants pay'), $this->settings->site_name));

        $data = $this->includes;

        // set content data
        $content_data = array(
					'merchant'  => $merchant,
					'amount'  => $amount,
					'currency'  => $currency_code,
					'symbol'  => $symbol,
					'item_name'  => $item_name,
					'total_fee'  => $total_fee,
					'total_amount'  => $total_amount,
					'custom'  => $custom,
        );

        // load views
        $data['content'] = $this->load->view('payment/index', $content_data, TRUE);
		    $this->load->view('../../assets/themes/sci/template', $data);
	}
	
/**
	 * Test mode
 */
	function test_mode()
	{
		

		$this->form_validation->set_rules('merchant', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[1]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		$this->form_validation->set_rules('item_name', lang('users transfer amount'), 'required|trim|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('custom', lang('users transfer amount'), 'required|trim|max_length[100]');
		
		if ($this->form_validation->run() == TRUE) {
			
			$id_merchant = $this->input->post("merchant");
			$amount = number_format($this->input->post("amount"), 2, '.', '');
			$currency = $this->input->post("currency");
			$item_name = $this->input->post("item_name");
			$custom = $this->input->post("custom");
					
			$merchant = $this->merchants_model->get_sci_merchant($id_merchant);
			
			// Check user
      $user = $this->users_model->get_username($merchant['user']);
				
				if ($merchant['test_mode'] == 1 && $merchant != NULL) {
					
					// Calculation of the commission and total sum
					$percent = $merchant['fee']/"100";
					$percent_fee = $amount * $percent;
					$total_fee_calc = $percent_fee + $merchant['fix_fee'];
					$total_fee = number_format($total_fee_calc, 2, '.', '');
					$total_amount_calc = $amount + $total_fee;
					$total_amount = number_format($total_amount_calc, 2, '.', '');

					$date = date('Y-m-d H:i:s');

					// send ipn information
					if ($merchant['status_link'] != NULL) {

						// create verify hash
						$hash_string = $total_amount.':'.$merchant['password'].':'.$date.':000000000';

						$hash = strtoupper(md5($hash_string));

						// Send POST request

						$url = $merchant['status_link'];  

						$post_data = array (
							// transaction info
							"amount" 		=> $amount,
							"fee" 			=> $total_fee,
							"total" 			=> $total_amount,
							"currency"    => $currency,
							"payer"    => "test",
							"receiver"    => $merchant['user'],
							"status" 		=> "Confirmed",
							"date" 			=> $date,
							"id_transfer" 	=> "000000000",
							// Merchant info
							"merchant_name" => $merchant['name'],
							"merchant_id" => $merchant['id'],
							"balance" 		=> $user[$currency],
							// Purchase Information
							"item_name" 		=> $item_name,
							"custom"		=> $custom,
							// Verification of the transaction
							"hash" 			=> $hash
						);

						$ch = curl_init();  

						curl_setopt($ch, CURLOPT_URL, $url);  

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

						curl_setopt($ch, CURLOPT_POST, 1);  

						curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  

						$output = curl_exec($ch);  

						curl_close($ch);  

						echo $output;

					}

					redirect($merchant['success_link']);
				
			} else {
				
				$this->session->set_flashdata('error', lang('users sci test_not_valid'));
				redirect(site_url());
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users sci fail_form'));
			redirect(site_url());
			
		}
		
	}
	
/**
	 * Check login
 */
	function start_payment()
	{
		
		 // set form validation rules
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('users input username_email'), 'required|trim|max_length[256]');
        $this->form_validation->set_rules('password', lang('users input password'), 'required|trim|max_length[72]|callback__check_login');
				$this->form_validation->set_rules('merchant', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
				$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[1]');
				$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
				$this->form_validation->set_rules('item_name', lang('users transfer amount'), 'required|trim|min_length[3]|max_length[100]');
				$this->form_validation->set_rules('custom', lang('users transfer amount'), 'required|trim|max_length[100]');

        if ($this->form_validation->run() == TRUE) {
					
						$id_merchant = $this->input->post("merchant");
						$amount = number_format($this->input->post("amount"), 2, '.', '');
						$currency = $this->input->post("currency");
						$item_name = $this->input->post("item_name");
						$custom = $this->input->post("custom");
					
						$merchant = $this->merchants_model->get_sci_merchant($id_merchant);
					
						$login = $this->users_model->login($this->input->post('username', TRUE), $this->input->post('password', TRUE));
					
						// Check user
      			$user = $this->users_model->get_username($login['username']);
					
						//your site secret key
						$secret = $this->settings->google_secret;
						//get verify response data
						$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
						$responseData = json_decode($verifyResponse);
						
						if($responseData->success && $merchant['test_mode'] == 0) {
							
							// Calculation of the commission and total sum
							$percent = $merchant['fee']/"100";
							$percent_fee = $amount * $percent;
							$total_fee_calc = $percent_fee + $merchant['fix_fee'];
							$total_fee = number_format($total_fee_calc, 2, '.', '');
							$total_amount_calc = $amount + $total_fee;
							$total_amount = number_format($total_amount_calc, 2, '.', '');
							
							$date = date('Y-m-d H:i:s');
							
							// Who pays the fees?
							if ($merchant['payeer_fee'] == "0") {
								
								if ($user[$currency] >= $amount) {
				
									$label = uniqid("sci_");

									// Check user merchant
									$merchant_user = $this->users_model->get_username($merchant['user']);

									// user wallet total
									$wallet_total_user = $user[$currency] - $amount;
									
									$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);
									
									// check user hold balance
									if ($wallet_total_user < $hold_balance) {

										$this->session->set_flashdata('error', lang('users error wallet'));
										redirect(site_url("account/dashboard"));

									} else {
										
										// update user wallet
										$this->users_model->update_wallet_transfer($user['username'],
											array(
												$currency => $wallet_total_user,
											)
										);

										// merchant wallet total
										$wallet_total_merchant = $merchant_user[$currency] + $amount - $total_fee;

										// update merchant wallet
										$this->users_model->update_wallet_transfer($merchant['user'],
											array(
												$currency => $wallet_total_merchant,
											)
										);

										// add new transaction
										$transactions = $this->transactions_model->add_transaction(array(
											"type" 				=> "5",
											"sum"  				=> $total_amount,
											"fee"    			=> $total_fee,
											"amount" 			=> $amount,
											"currency"		=> $currency,
											"status" 			=> "2",
											"sender" 			=> $user['username'],
											"receiver" 		=> $merchant['user'],
											"time"          	=> $date,
											"label" 	    => $label,
											"admin_comment" 	    => "merchant fee",
											"user_comment" 	    => $item_name,
											"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
											"protect" 	    => "none",
											"merchant" => $merchant['id'],
											"payer_fee" => "1",
											)
										);
										
										$merch_user = $this->users_model->get_username($merchant['user']);
										
										$mail_amount = number_format($total_amount, 2, '.', '');
											
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
												$name_user = $merchant['first_name'] . ' ' . $merchant['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($merch_user['email']);
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

												$result = $this->sms->send_sms($merch_user['phone'], $str_1);

											}

										$id_transaction = $this->transactions_model->get_label($label);

										// send ipn information
										if ($merchant['status_link'] != NULL) {

											// create verify hash
											$hash_string = $total_amount.':'.$merchant['password'].':'.$date.':'.$id_transaction['id'];

											$hash = strtoupper(md5($hash_string));

											// Send POST request

											$url = $merchant['status_link'];  

											$post_data = array (
												// transaction info
												"amount" 		=> $amount,
												"fee" 			=> $total_fee,
												"total" 			=> $total_amount,
												"currency"    => $currency,
												"payer"    => $user['username'],
												"receiver"    => $merchant['user'],
												"status" 		=> "Confirmed",
												"date" 			=> $date,
												"id_transfer" 	=> $id_transaction['id'],
												// Merchant info
												"merchant_name" => $merchant['name'],
												"merchant_id" => $merchant['id'],
												"balance" 		=> $wallet_total_merchant,
												// Purchase Information
												"item_name" 		=> $item_name,
												"custom"		=> $custom,
												// Verification of the transaction
												"hash" 			=> $hash
											);

											$ch = curl_init();  

											curl_setopt($ch, CURLOPT_URL, $url);  

											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

											curl_setopt($ch, CURLOPT_POST, 1);  

											curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  

											$output = curl_exec($ch);  

											curl_close($ch);  

											echo $output;

										}

										redirect($merchant['success_link']);

										}

								} else {

									// no money to pay
									redirect($merchant['fail_link']);

								}
								
							} else {
								
								if ($user[$currency] >= $total_amount) {
				
									$label = uniqid("sci_");

									// Check user merchant
									$merchant_user = $this->users_model->get_username($merchant['user']);

									// user wallet total
									$wallet_total_user = $user[$currency] - $total_amount;
									
									$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);
									
									// check user hold balance
									if ($wallet_total_user < $hold_balance) {

										$this->session->set_flashdata('error', lang('users error wallet'));
										redirect(site_url("account/dashboard"));

									} else {
										
										// update user wallet
										$this->users_model->update_wallet_transfer($user['username'],
											array(
												$currency => $wallet_total_user,
											)
										);

										// merchant wallet total
										$wallet_total_merchant = $merchant_user[$currency] + $amount;

										// update merchant wallet
										$this->users_model->update_wallet_transfer($merchant['user'],
											array(
												$currency => $wallet_total_merchant,
											)
										);

										// add new transaction
										$transactions = $this->transactions_model->add_transaction(array(
											"type" 				=> "5",
											"sum"  				=> $total_amount,
											"fee"    			=> $total_fee,
											"amount" 			=> $amount,
											"currency"		=> $currency,
											"status" 			=> "2",
											"sender" 			=> $user['username'],
											"receiver" 		=> $merchant['user'],
											"time"          	=> $date,
											"label" 	    => $label,
											"admin_comment" 	    => "none",
											"user_comment" 	    => $item_name,
											"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
											"protect" 	    => "none",
											"merchant" => $merchant['id'],
											)
										);
										
										$mail_amount = number_format($amount, 2, '.', '');
											
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
												$name_user = $merchant['first_name'] . ' ' . $merchant['last_name'];

												$rawstring = $email_template['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($merch_user['email']);
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

												$result = $this->sms->send_sms($merch_user['phone'], $str_1);

											}

										$id_transaction = $this->transactions_model->get_label($label);

										// send ipn information
										if ($merchant['status_link'] != NULL) {

											// create verify hash
											$hash_string = $total_amount.':'.$merchant['password'].':'.$date.':'.$id_transaction['id'];

											$hash = strtoupper(md5($hash_string));

											// Send POST request

											$url = $merchant['status_link'];  

											$post_data = array (
												// transaction info
												"amount" 		=> $amount,
												"fee" 			=> $total_fee,
												"total" 			=> $total_amount,
												"currency"    => $currency,
												"payer"    => $user['username'],
												"receiver"    => $merchant['user'],
												"status" 		=> "Confirmed",
												"date" 			=> $date,
												"id_transfer" 	=> $id_transaction['id'],
												// Merchant info
												"merchant_name" => $merchant['name'],
												"merchant_id" => $merchant['id'],
												"balance" 		=> $wallet_total_merchant,
												// Purchase Information
												"item_name" 		=> $item_name,
												"custom"		=> $custom,
												// Verification of the transaction
												"hash" 			=> $hash
											);

											$ch = curl_init();  

											curl_setopt($ch, CURLOPT_URL, $url);  

											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  

											curl_setopt($ch, CURLOPT_POST, 1);  

											curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  

											$output = curl_exec($ch);  

											curl_close($ch);  

											echo $output;

										}

										redirect($merchant['success_link']);
										
									}


								} else {

								// no money to pay
								redirect($merchant['fail_link']);

							}
								
							}
							
							
						} else {
							
							$this->session->set_flashdata('error', lang('users sci captcha_not_valid'));
							redirect(site_url());
							
						}
            
        } else {
					
					$this->session->set_flashdata('error', lang('users sci account_not_valid'));
					redirect(site_url());
					
				}
	}
	
	/**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/


    /**
     * Verify the login credentials
     *
     * @param  string $password
     * @return boolean
     */
    function _check_login($password)
    {
        // limit number of login attempts
        $ok_to_login = $this->users_model->login_attempts();

        if ($ok_to_login)
        {
            $login = $this->users_model->login($this->input->post('username', TRUE), $password);

            if ($login)
            {
                // $this->session->set_userdata('logged_in', $login);

								return TRUE;
            }

            $this->form_validation->set_message('_check_login', lang('users error invalid_login'));
            return FALSE;
        }

        $this->form_validation->set_message('_check_login', sprintf(lang('users error too_many_login_attempts'), $this->config->item('login_max_time')));
        return FALSE;
    }
  
  
}