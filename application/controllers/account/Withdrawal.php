<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/


class Withdrawal extends Private_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language file
        $this->lang->load('users');

        // load the users model
        $this->load->model('users_model');
        $this->load->model('transactions_model');
    }
  
    /**
	*  Main page
    */
	function index()
	{

		// setup page header data
	    $this->set_title(sprintf(lang('users title withdrawal'), $this->settings->site_name));
		// reload the new user data and store in session
	    $user = $this->users_model->get_user($this->user['id']);
	    
	    $paypal = $this->settings_model->get_win_method(1);
		$credit_card = $this->settings_model->get_win_method(2);
		$bitcoin = $this->settings_model->get_win_method(3);
		$skrill = $this->settings_model->get_win_method(5);
		$payza = $this->settings_model->get_win_method(6);
		$advcash = $this->settings_model->get_win_method(7);
		$perfect_m = $this->settings_model->get_win_method(8);
		$swift = $this->settings_model->get_win_method(4);
    
    	// Check enabled method PayPal
		if ($paypal['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_paypal = TRUE;

		} elseif ($paypal['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_paypal = TRUE;

		} elseif ($paypal['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_paypal = TRUE;

		} else {

			$enabled_paypal = FALSE;

		}
		
		// Check enabled method Credit card
		if ($credit_card['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_credit_card = TRUE;

		} elseif ($credit_card['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_credit_card = TRUE;

		} elseif ($credit_card['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_credit_card = TRUE;

		} else {

			$enabled_credit_card = FALSE;

		}
		
		// Check enabled method bitcoin
		if ($bitcoin['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_bitcoin = TRUE;

		} elseif ($bitcoin['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_bitcoin = TRUE;

		} elseif ($bitcoin['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_bitcoin = TRUE;

		} else {

			$enabled_bitcoin = FALSE;

		}
		
		// Check enabled method Skrill
		if ($skrill['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_skrill = TRUE;

		} elseif ($skrill['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_skrill = TRUE;

		} elseif ($skrill['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_skrill = TRUE;

		} else {

			$enabled_skrill = FALSE;

		}
		
		// Check enabled method Payza
		if ($payza['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_payza = TRUE;

		} elseif ($payza['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_payza = TRUE;

		} elseif ($payza['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_payza = TRUE;

		} else {

			$enabled_payza = FALSE;

		}
		
		// Check enabled method Advcash
		if ($advcash['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_advcash = TRUE;

		} elseif ($advcash['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_advcash = TRUE;

		} elseif ($advcash['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_advcash = TRUE;

		} else {

			$enabled_advcash = FALSE;

		}
		
		// Check enabled method Perfect Money
		if ($perfect_m['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_perfect_m = TRUE;

		} elseif ($perfect_m['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_perfect_m = TRUE;

		} elseif ($perfect_m['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_perfect_m = TRUE;

		} else {

			$enabled_perfect_m = FALSE;

		}
		
		// Check enabled method SWIFT
		if ($swift['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled_swift = TRUE;

		} elseif ($swift['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled_swift = TRUE;

		} elseif ($swift['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled_swift = TRUE;

		} else {

			$enabled_swift = FALSE;

		}
				
    	$data = $this->includes;

	    // set content data
	    $content_data = array(
			'user'    				=> $user,
	      	'paypal'            	=> $paypal,
			'enabled_paypal'    	=> $enabled_paypal,
			'credit_card'       	=> $credit_card,
			'enabled_credit_card'   => $enabled_credit_card,
			'bitcoin'           	=> $bitcoin,
			'enabled_bitcoin'   	=> $enabled_bitcoin,
			'skrill'            	=> $skrill,
			'enabled_skrill'    	=> $enabled_skrill,
			'payza'             	=> $payza,
			'enabled_payza'     	=> $enabled_payza,
			'advcash'           	=> $advcash,
			'enabled_advcash'   	=> $enabled_advcash,
			'perfect_m'         	=> $perfect_m,
			'enabled_perfect_m' 	=> $enabled_perfect_m,
			'swift'             	=> $swift,
			'enabled_swift'     	=> $enabled_swift,
    	);

	    // load views
	    $data['content'] = $this->load->view('account/withdrawal/index', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	/**
	*  Confirmation of withdrawal request
    */
	function confirm()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$paypal = $this->settings_model->get_win_method(1);
		$credit_card = $this->settings_model->get_win_method(2);
		$bitcoin = $this->settings_model->get_win_method(3);
		$skrill = $this->settings_model->get_win_method(5);
		$payza = $this->settings_model->get_win_method(6);
		$advcash = $this->settings_model->get_win_method(7);
		$perfect_m = $this->settings_model->get_win_method(8);
		$swift = $this->settings_model->get_win_method(4);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric');
		$this->form_validation->set_rules('method', lang('users withdrawal method'), 'required|trim|in_list[paypal,credit_card,bitcoin,swift,skrill,payza,advcash,perfect_m]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users withdrawal error_1'));
			redirect(site_url("account/withdrawal"));

		} else {

			$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
			$currency = $this->input->post("currency", TRUE);
			$method = $this->input->post("method", TRUE);
			
			if ($method == "paypal") {
				
				$method = $paypal['name'];
				$fee = $paypal['fee'];
				$fee_fix = $paypal['fee_fix'];
				$account = $user['paypal'];
				$terms = $paypal['terms'];
				$minimum = $paypal['minimum_'.$currency.''];
				$maximum = $paypal['maximum_'.$currency.''];
				$code_method = "paypal";
				$check_method_account_user = "paypal";
				
				if ($paypal['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($paypal['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($paypal['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "credit_card") {
				
				$method = $credit_card['name'];
				$fee = $credit_card['fee'];
				$fee_fix = $credit_card['fee_fix'];
				$account = $user['card'];
				$terms = $credit_card['terms'];
				$minimum = $credit_card['minimum_'.$currency.''];
				$maximum = $credit_card['maximum_'.$currency.''];
				$code_method = "credit_card";
				$check_method_account_user = "card";
				
				if ($credit_card['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($credit_card['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($credit_card['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "bitcoin") {
				
				$method = $bitcoin['name'];
				$fee = $bitcoin['fee'];
				$fee_fix = $bitcoin['fee_fix'];
				$account = $user['bitcoin'];
				$terms = $bitcoin['terms'];
				$minimum = $bitcoin['minimum_'.$currency.''];
				$maximum = $bitcoin['maximum_'.$currency.''];
				$code_method = "bitcoin";
				$check_method_account_user = "bitcoin";
				
				if ($bitcoin['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($bitcoin['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($bitcoin['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "swift") {
				
				$method = $swift['name'];
				$fee = $swift['fee'];
				$fee_fix = $swift['fee_fix'];
				$account = $user['swift'];
				$terms = $swift['terms'];
				$minimum = $swift['minimum_'.$currency.''];
				$maximum = $swift['maximum_'.$currency.''];
				$code_method = "swift";
				$check_method_account_user = "swift";
				
				if ($swift['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($swift['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($swift['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "skrill") {
				
				$method = $skrill['name'];
				$fee = $skrill['fee'];
				$fee_fix = $skrill['fee_fix'];
				$account = $user['skrill'];
				$terms = $skrill['terms'];
				$minimum = $skrill['minimum_'.$currency.''];
				$maximum = $skrill['maximum_'.$currency.''];
				$code_method = "skrill";
				$check_method_account_user = "skrill";
				
				if ($skrill['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($skrill['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($skrill['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "payza") {
				
				$method = $payza['name'];
				$fee = $payza['fee'];
				$fee_fix = $payza['fee_fix'];
				$account = $user['payza'];
				$terms = $payza['terms'];
				$minimum = $payza['minimum_'.$currency.''];
				$maximum = $payza['maximum_'.$currency.''];
				$code_method = "payza";
				$check_method_account_user = "payza";
				
				if ($payza['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($payza['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($payza['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "advcash") {
				
				$method = $advcash['name'];
				$fee = $advcash['fee'];
				$fee_fix = $advcash['fee_fix'];
				$account = $user['advcash'];
				$terms = $advcash['terms'];
				$minimum = $advcash['minimum_'.$currency.''];
				$maximum = $advcash['maximum_'.$currency.''];
				$code_method = "advcash";
				$check_method_account_user = "advcash";
				
				if ($advcash['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($advcash['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($advcash['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			} elseif ($method == "perfect_m") {
				
				$method = $perfect_m['name'];
				$fee = $perfect_m['fee'];
				$fee_fix = $perfect_m['fee_fix'];
				$account = $user['perfect_m'];
				$terms = $perfect_m['terms'];
				$minimum = $perfect_m['minimum_'.$currency.''];
				$maximum = $perfect_m['maximum_'.$currency.''];
				$code_method = "perfect_m";
				$check_method_account_user = "perfect_m";
				
				if ($perfect_m['start_verify'] == "1" && $user['verify_status'] == 0) {

					$verify_status = TRUE;

				} elseif ($perfect_m['standart_verify'] == "1" && $user['verify_status'] == 1) {

					$verify_status = TRUE;

				} elseif ($perfect_m['expanded_verify'] == "1" && $user['verify_status'] == 2) {

					$verify_status = TRUE;

				} else {

					$verify_status = FALSE;

				}
				
			}
			
			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_fee = number_format($total_fee_calc, 2, '.', '');
			$total_amount_calc = $amount + $total_fee;
			$total_amount = number_format($total_amount_calc, 2, '.', '');
			
			// Check amount for minimum and maximum limits
			if ($minimum > $amount) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/withdrawal"));
				
			} elseif ($maximum < $amount) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/withdrawal"));
				
			}
			
			// Check verify status
			if ($user[$check_method_account_user] == NULL) {
				
				$this->session->set_flashdata('error', lang('users withdrawal null_account'));
				redirect(site_url("account/withdrawal"));
				
			}
			
			// Check verify status
			if ($verify_status == FALSE) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_4'));
				redirect(site_url("account/withdrawal"));
				
			}
			
		}
		
	    // setup page header data
	    $this->set_title(sprintf(lang('users title withdrawal'), $this->settings->site_name));

	    $data = $this->includes;
		
    	// set content data
    	$content_data = array(
			'user'              => $user,
			'total_amount'      => $total_amount,
			'total_fee'         => $total_fee,
			'amount'            => $amount,
			'currency'          => $currency,
			'method'            => $method,
			'account'           => $account,
			'terms'             => $terms,
			'code_method'       => $code_method,
     	);

    	// load views
    	$data['content'] = $this->load->view('account/withdrawal/confirm', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	/**
	*  Start withdrawal request
    */
	function start_withdrawal()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$paypal = $this->settings_model->get_win_method(1);
		$credit_card = $this->settings_model->get_win_method(2);
		$bitcoin = $this->settings_model->get_win_method(3);
		$skrill = $this->settings_model->get_win_method(5);
		$payza = $this->settings_model->get_win_method(6);
		$advcash = $this->settings_model->get_win_method(7);
		$perfect_m = $this->settings_model->get_win_method(8);
		$swift = $this->settings_model->get_win_method(4);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric');
		$this->form_validation->set_rules('method', lang('users withdrawal method'), 'required|trim|in_list[paypal,credit_card,bitcoin,swift,skrill,payza,advcash,perfect_m]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users withdrawal error_1'));
			redirect(site_url("account/withdrawal"));

		} else {

			if ($user['fraud'] == 0) {

				if ($user['login_status'] == 2) {

					$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
					$currency = $this->input->post("currency", TRUE);
					$method = $this->input->post("method", TRUE);
					
					if ($method == "paypal") {
						
						$method = $paypal['name'];
						$fee = $paypal['fee'];
						$fee_fix = $paypal['fee_fix'];
						$account = $user['paypal'];
						$terms = $paypal['terms'];
						$minimum = $paypal['minimum_'.$currency.''];
						$maximum = $paypal['maximum_'.$currency.''];
						
						if ($paypal['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($paypal['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($paypal['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "credit_card") {
						
						$method = $credit_card['name'];
						$fee = $credit_card['fee'];
						$fee_fix = $credit_card['fee_fix'];
						$account = $user['card'];
						$terms = $credit_card['terms'];
						$minimum = $credit_card['minimum_'.$currency.''];
						$maximum = $credit_card['maximum_'.$currency.''];
						
						if ($credit_card['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($credit_card['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($credit_card['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "bitcoin") {
						
						$method = $bitcoin['name'];
						$fee = $bitcoin['fee'];
						$fee_fix = $bitcoin['fee_fix'];
						$account = $user['bitcoin'];
						$terms = $bitcoin['terms'];
						$minimum = $bitcoin['minimum_'.$currency.''];
						$maximum = $bitcoin['maximum_'.$currency.''];
						
						if ($bitcoin['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($bitcoin['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($bitcoin['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "swift") {
						
						$method = $swift['name'];
						$fee = $swift['fee'];
						$fee_fix = $swift['fee_fix'];
						$account = $user['swift'];
						$terms = $swift['terms'];
						$minimum = $swift['minimum_'.$currency.''];
						$maximum = $swift['maximum_'.$currency.''];
						
						if ($swift['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($swift['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($swift['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "skrill") {
						
						$method = $skrill['name'];
						$fee = $skrill['fee'];
						$fee_fix = $skrill['fee_fix'];
						$account = $user['skrill'];
						$terms = $skrill['terms'];
						$minimum = $skrill['minimum_'.$currency.''];
						$maximum = $skrill['maximum_'.$currency.''];
						
						if ($skrill['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($skrill['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($skrill['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "payza") {
						
						$method = $payza['name'];
						$fee = $payza['fee'];
						$fee_fix = $payza['fee_fix'];
						$account = $user['payza'];
						$terms = $payza['terms'];
						$minimum = $payza['minimum_'.$currency.''];
						$maximum = $payza['maximum_'.$currency.''];
						
						if ($payza['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($payza['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($payza['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "advcash") {
						
						$method = $advcash['name'];
						$fee = $advcash['fee'];
						$fee_fix = $advcash['fee_fix'];
						$account = $user['advcash'];
						$terms = $advcash['terms'];
						$minimum = $advcash['minimum_'.$currency.''];
						$maximum = $advcash['maximum_'.$currency.''];
						
						if ($advcash['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($advcash['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($advcash['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					} elseif ($method == "perfect_m") {
						
						$method = $perfect_m['name'];
						$fee = $perfect_m['fee'];
						$fee_fix = $perfect_m['fee_fix'];
						$account = $user['perfect_m'];
						$terms = $perfect_m['terms'];
						$minimum = $perfect_m['minimum_'.$currency.''];
						$maximum = $perfect_m['maximum_'.$currency.''];
						
						if ($perfect_m['start_verify'] == "1" && $user['verify_status'] == 0) {

							$verify_status = TRUE;

						} elseif ($perfect_m['standart_verify'] == "1" && $user['verify_status'] == 1) {

							$verify_status = TRUE;

						} elseif ($perfect_m['expanded_verify'] == "1" && $user['verify_status'] == 2) {

							$verify_status = TRUE;

						} else {

							$verify_status = FALSE;

						}
						
					}
					
					// Calculation of the commission and total sum
					$percent = $fee/"100";
					$percent_fee = $amount * $percent;
					$total_fee_calc = $percent_fee + $fee_fix;
					$total_fee = number_format($total_fee_calc, 2, '.', '');
					$total_amount_calc = $amount + $total_fee;
					$total_amount = number_format($total_amount_calc, 2, '.', '');
					
					if ($minimum > $amount & $maximum < $amount & $verify_status == FALSE) {
						
						$this->session->set_flashdata('error', lang('users withdrawal error_3'));
						redirect(site_url("account/withdrawal"));
						
					} else {
						
						$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);
						
						$wallet_remainder = $user[$currency] - $total_amount;
						
						// check user hold balance
						if ($wallet_remainder < $hold_balance) {
								
							$this->session->set_flashdata('error', lang('users error wallet'));
							redirect(site_url("account/withdrawal"));
								
						} else {
							
							// wallet user update
							if($user[$currency] >= $total_amount) {

								$label = uniqid("wfs_");


								$this->users_model->update_wallet_transfer($user['username'],
									array(
										$currency => $wallet_remainder,
									)
								);

								// add new transaction
								$transactions = $this->transactions_model->add_transaction(array(
									"type" 				=> "2",
									"sum"  				=> $total_amount,
									"fee"    			=> $total_fee,
									"amount" 			=> $amount,
									"currency"			=> $currency,
									"status" 			=> "1",
									"sender" 			=> $user['username'],
									"receiver" 			=> "system",
									"time"          	=> date('Y-m-d H:i:s'),
									"label" 	    	=> $label,
									"admin_comment" 	=> $method,
									"user_comment" 	    => $method,
									"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
									"protect" 	    	=> "none",
									)
								);
								
								$email_template = $this->template_model->get_email_template(10);
						
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
									$link = site_url('account/transactions');
									$name_user = $user['first_name'] . ' ' . $user['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[SUM]','[CUR]');

									$vals_1 = array($site_name, $link, $name_user, $amount, $symbol);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
								
								$sms_template = $this->template_model->get_sms_template(8);
									
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
									$placeholders = array('[SUM]','[CUR]');

									$vals_1 = array($amount, $symbol);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$result = $this->sms->send_sms($user['phone'], $str_1);
												
								}

								$this->session->set_flashdata('message', lang('users transfer success'));
								redirect(site_url("account/transactions"));

							} else {

								$this->session->set_flashdata('error', lang('users error wallet'));
								redirect(site_url("account/withdrawal"));

							}
							
						}
						
					}

				} else {

					$this->session->set_flashdata('error', lang('users error fraud'));
					redirect(site_url("account/cart"));

				} 
				
			} else {

				$this->session->set_flashdata('error', lang('users error fraud'));
				redirect(site_url("account/cart"));
				
			}

			
			
		}
		
	}
  
}