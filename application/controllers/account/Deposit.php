<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends Private_Controller {

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
				$this->load->library('fixer');
    }
  
    /**
	*  Main page
    */
	function index()
	{
		// setup page header data
    $this->set_title(sprintf(lang('users dashboard deposit'), $this->settings->site_name));
		// reload the new user data and store in session
    $user = $this->users_model->get_user($this->user['id']);
    
    $paypal = $this->settings_model->get_dep_method(1);
		$perfect_m = $this->settings_model->get_dep_method(2);
		$advcash = $this->settings_model->get_dep_method(3);
		$payeer = $this->settings_model->get_dep_method(4);
		$skrill = $this->settings_model->get_dep_method(5);
		$paygol = $this->settings_model->get_dep_method(6);
		$swift = $this->settings_model->get_dep_method(7);
		$local_bank = $this->settings_model->get_dep_method(8);
		$coinpayments = $this->settings_model->get_dep_method(9);
		$blockchain = $this->settings_model->get_dep_method(10);
    
    if ($paypal['start_verify'] == "1" && $user['verify_status'] == 0) {
			$enabled_paypal = TRUE;
		} elseif ($paypal['standart_verify'] == "1" && $user['verify_status'] == 1) {
			$enabled_paypal = TRUE;
		} elseif ($paypal['expanded_verify'] == "1" && $user['verify_status'] == 2) {
			$enabled_paypal = TRUE;
		} else {
			$enabled_paypal = FALSE;
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
		
		// Check enabled method Payeer
		if ($payeer['start_verify'] == "1" && $user['verify_status'] == 0) {
			$enabled_payeer = TRUE;
		} elseif ($payeer['standart_verify'] == "1" && $user['verify_status'] == 1) {
			$enabled_payeer = TRUE;
		} elseif ($payeer['expanded_verify'] == "1" && $user['verify_status'] == 2) {
			$enabled_payeer = TRUE;
		} else {
			$enabled_payeer = FALSE;
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
		
		// Check enabled method Paygol
		if ($paygol['start_verify'] == "1" && $user['verify_status'] == 0) {
			$enabled_paygol = TRUE;
		} elseif ($paygol['standart_verify'] == "1" && $user['verify_status'] == 1) {
			$enabled_paygol = TRUE;
		} elseif ($paygol['expanded_verify'] == "1" && $user['verify_status'] == 2) {
			$enabled_paygol = TRUE;
		} else {
			$enabled_paygol = FALSE;
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
		
		// Check enabled method Local Bank
		if ($local_bank['start_verify'] == "1" && $user['verify_status'] == 0) {
			$enabled_local_bank = TRUE;
		} elseif ($local_bank['standart_verify'] == "1" && $user['verify_status'] == 1) {
			$enabled_local_bank = TRUE;
		} elseif ($local_bank['expanded_verify'] == "1" && $user['verify_status'] == 2) {
			$enabled_local_bank = TRUE;
		} else {
			$enabled_local_bank = FALSE;
		}
		
		// Check enabled method Coinpayments
		if ($coinpayments['start_verify'] == "1" && $user['verify_status'] == 0) {
			$enabled_coinpayments = TRUE;
		} elseif ($coinpayments['standart_verify'] == "1" && $user['verify_status'] == 1) {
			$enabled_coinpayments = TRUE;
		} elseif ($coinpayments['expanded_verify'] == "1" && $user['verify_status'] == 2) {
			$enabled_coinpayments = TRUE;
		} else {
			$enabled_coinpayments = FALSE;
		}
		
		// Check enabled method Coinpayments
		if ($blockchain['start_verify'] == "1" && $user['verify_status'] == 0) {
			$enabled_blockchain = TRUE;
		} elseif ($blockchain['standart_verify'] == "1" && $user['verify_status'] == 1) {
			$enabled_blockchain = TRUE;
		} elseif ($blockchain['expanded_verify'] == "1" && $user['verify_status'] == 2) {
			$enabled_blockchain = TRUE;
		} else {
			$enabled_blockchain = FALSE;
		}
    
    $data = $this->includes;
    
    // set content data
    $content_data = array(
			'user'    => $user,
      'paypal'            => $paypal,
			'enabled_paypal'    => $enabled_paypal,
			'perfect_m'         => $perfect_m,
			'enabled_perfect_m' => $enabled_perfect_m,
			'advcash'           => $advcash,
			'enabled_advcash'   => $enabled_advcash,
			'payeer'            => $payeer,
			'enabled_payeer'    => $enabled_payeer,
			'skrill'             => $skrill,
			'enabled_skrill'     => $enabled_skrill,
			'paygol'             => $paygol,
			'enabled_paygol'     => $enabled_paygol,
			'swift'             => $swift,
			'enabled_swift'     => $enabled_swift,
			'local_bank'             => $local_bank,
			'enabled_local_bank'     => $enabled_local_bank,
			'coinpayments'             => $coinpayments,
			'enabled_coinpayments'     => $enabled_coinpayments,
			'blockchain'             => $blockchain,
			'enabled_blockchain'     => $enabled_blockchain,
    );
    
    // load views
    $data['content'] = $this->load->view('account/deposit/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
    
  }
	
	function confirm()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$paypal = $this->settings_model->get_dep_method(1);
		$perfect_m = $this->settings_model->get_dep_method(2);
		$advcash = $this->settings_model->get_dep_method(3);
		$payeer = $this->settings_model->get_dep_method(4);
		$skrill = $this->settings_model->get_dep_method(5);
		$paygol = $this->settings_model->get_dep_method(6);
		$swift = $this->settings_model->get_dep_method(7);
		$local_bank = $this->settings_model->get_dep_method(8);
		$coinpayments = $this->settings_model->get_dep_method(9);
		$blockchain = $this->settings_model->get_dep_method(10);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric');
		$this->form_validation->set_rules('method', lang('users withdrawal method'), 'required|trim|in_list[paypal,perfect_m,advcash,payeer,skrill,paygol,swift,local_bank,coinpayments,blockchain]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users withdrawal error_1'));
			redirect(site_url("account/deposit"));

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
				
				// check verify level
				if ($paypal['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($paypal['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($paypal['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $paypal['debit_base'] == "1") {
					$merchant_account = $paypal['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $paypal['debit_extra1'] == "1") {
					$merchant_account = $paypal['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $paypal['debit_extra2']) {
					$merchant_account = $paypal['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $paypal['debit_extra3']) {
					$merchant_account = $paypal['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $paypal['debit_extra4']) {
					$merchant_account = $paypal['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $paypal['debit_extra5']) {
					$merchant_account = $paypal['ac_debit_extra5'];
				} else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "perfect_m") {
				
				$method = $perfect_m['name'];
				$fee = $perfect_m['fee'];
				$fee_fix = $perfect_m['fee_fix'];
				$account = $user['perfect_m'];
				$minimum = $perfect_m['minimum_'.$currency.''];
				$maximum = $perfect_m['maximum_'.$currency.''];
				$code_method = "perfect_m";
				
				if ($perfect_m['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($perfect_m['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($perfect_m['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $perfect_m['debit_base'] == "1") {
					$merchant_account = $perfect_m['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $perfect_m['debit_extra1'] == "1") {
					$merchant_account = $perfect_m['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $perfect_m['debit_extra2']) {
					$merchant_account = $perfect_m['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $perfect_m['debit_extra3']) {
					$merchant_account = $perfect_m['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $perfect_m['debit_extra4']) {
					$merchant_account = $perfect_m['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $perfect_m['debit_extra5']) {
					$merchant_account = $perfect_m['ac_debit_extra5'];
				} else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "advcash") {
				
				$method = $advcash['name'];
				$fee = $advcash['fee'];
				$fee_fix = $advcash['fee_fix'];
				$minimum = $advcash['minimum_'.$currency.''];
				$maximum = $advcash['maximum_'.$currency.''];
				$code_method = "advcash";
				
				if ($advcash['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($advcash['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($advcash['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $advcash['debit_base'] == "1") {
					$merchant_account = $advcash['ac_debit_base'];
					$symbol = $this->currencys->display->base_code;
				} elseif ($currency == "debit_extra1" && $advcash['debit_extra1'] == "1") {
					$merchant_account = $advcash['ac_debit_extra1'];
					$symbol = $this->currencys->display->extra1_code;
				} elseif ($currency == "debit_extra2" && $advcash['debit_extra2'] == "1") {
					$merchant_account = $advcash['ac_debit_extra2'];
					$symbol = $this->currencys->display->extra2_code;
				} elseif ($currency == "debit_extra3" && $advcash['debit_extra3'] == "1") {
					$merchant_account = $advcash['ac_debit_extra3'];
					$symbol = $this->currencys->display->extra3_code;
				} elseif ($currency =="debit_extra4" && $advcash['debit_extra4'] == "1") {
					$merchant_account = $advcash['ac_debit_extra4'];
					$symbol = $this->currencys->display->extra4_code;
				} elseif ($currency =="debit_extra5" && $advcash['debit_extra5'] == "1") {
					$merchant_account = $advcash['ac_debit_extra5'];
					$symbol = $this->currencys->display->extra5_code;
				} else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "payeer") {
				
				$method = $payeer['name'];
				$fee = $payeer['fee'];
				$fee_fix = $payeer['fee_fix'];
				$minimum = $payeer['minimum_'.$currency.''];
				$maximum = $payeer['maximum_'.$currency.''];
				$code_method = "payeer";
				
				if ($payeer['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($payeer['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($payeer['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $payeer['debit_base'] == "1") {
					$merchant_account = $payeer['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $payeer['debit_extra1'] == "1") {
					$merchant_account = $payeer['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $payeer['debit_extra2'] == "1") {
					$merchant_account = $payeer['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $payeer['debit_extra3'] == "1") {
					$merchant_account = $payeer['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $payeer['debit_extra4'] == "1") {
					$merchant_account = $payeer['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $payeer['debit_extra5'] == "1") {
					$merchant_account = $payeer['ac_debit_extra5'];
				} else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "skrill") {
				
				$method = $skrill['name'];
				$fee = $skrill['fee'];
				$fee_fix = $skrill['fee_fix'];
				$minimum = $skrill['minimum_'.$currency.''];
				$maximum = $skrill['maximum_'.$currency.''];
				$code_method = "skrill";
				
				if ($skrill['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($skrill['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($skrill['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $skrill['debit_base'] == "1") {
					$merchant_account = $skrill['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $skrill['debit_extra1'] == "1") {
					$merchant_account = $skrill['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $skrill['debit_extra2'] == "1") {
					$merchant_account = $skrill['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $skrill['debit_extra3'] == "1") {
					$merchant_account = $skrill['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $skrill['debit_extra4'] == "1") {
					$merchant_account = $skrill['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $skrill['debit_extra5'] == "1") {
					$merchant_account = $skrill['ac_debit_extra5'];
				}	else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "paygol") {
				
				$method = $paygol['name'];
				$fee = $paygol['fee'];
				$fee_fix = $paygol['fee_fix'];
				$minimum = $paygol['minimum_'.$currency.''];
				$maximum = $paygol['maximum_'.$currency.''];
				$code_method = "paygol";
				
				if ($paygol['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($paygol['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($paygol['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $paygol['debit_base'] == "1") {
					$merchant_account = $paygol['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $paygol['debit_extra1'] == "1") {
					$merchant_account = $paygol['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $paygol['debit_extra2'] == "1") {
					$merchant_account = $paygol['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $paygol['debit_extra3'] == "1") {
					$merchant_account = $paygol['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $paygol['debit_extra4'] == "1") {
					$merchant_account = $paygol['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $paygol['debit_extra5'] == "1") {
					$merchant_account = $paygol['ac_debit_extra5'];
				}	else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "swift") {
				
				$method = $swift['name'];
				$fee = $swift['fee'];
				$fee_fix = $swift['fee_fix'];
				$minimum = $swift['minimum_'.$currency.''];
				$maximum = $swift['maximum_'.$currency.''];
				$code_method = "swift";
				
				if ($swift['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($swift['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($swift['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $swift['debit_base'] == "1") {
					$merchant_account = $swift['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $swift['debit_extra1'] == "1") {
					$merchant_account = $swift['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $swift['debit_extra2'] == "1") {
					$merchant_account = $swift['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $swift['debit_extra3'] == "1") {
					$merchant_account = $swift['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $swift['debit_extra4'] == "1") {
					$merchant_account = $swift['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $swift['debit_extra5'] == "1") {
					$merchant_account = $swift['ac_debit_extra5'];
				}	else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "local_bank") {
				
				$method = $local_bank['name'];
				$fee = $local_bank['fee'];
				$fee_fix = $local_bank['fee_fix'];
				$minimum = $local_bank['minimum_'.$currency.''];
				$maximum = $local_bank['maximum_'.$currency.''];
				$code_method = "local_bank";
				
				if ($local_bank['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($local_bank['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($local_bank['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $local_bank['debit_base'] == "1") {
					$merchant_account = $local_bank['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $local_bank['debit_extra1'] == "1") {
					$merchant_account = $local_bank['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $local_bank['debit_extra2'] == "1") {
					$merchant_account = $local_bank['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $local_bank['debit_extra3'] == "1") {
					$merchant_account = $local_bank['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $local_bank['debit_extra4'] == "1") {
					$merchant_account = $local_bank['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $local_bank['debit_extra5'] == "1") {
					$merchant_account = $local_bank['ac_debit_extra5'];
				}	else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "coinpayments") {
				
				$method = $coinpayments['name'];
				$fee = $coinpayments['fee'];
				$fee_fix = $coinpayments['fee_fix'];
				$minimum = $coinpayments['minimum_'.$currency.''];
				$maximum = $coinpayments['maximum_'.$currency.''];
				$code_method = "coinpayments";
				
				if ($coinpayments['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($coinpayments['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($coinpayments['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $coinpayments['debit_base'] == "1") {
					$merchant_account = $coinpayments['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $coinpayments['debit_extra1'] == "1") {
					$merchant_account = $coinpayments['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $coinpayments['debit_extra2'] == "1") {
					$merchant_account = $coinpayments['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $coinpayments['debit_extra3'] == "1") {
					$merchant_account = $coinpayments['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $coinpayments['debit_extra4'] == "1") {
					$merchant_account = $coinpayments['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $coinpayments['debit_extra5'] == "1") {
					$merchant_account = $coinpayments['ac_debit_extra5'];
				}	else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			} elseif ($method == "blockchain") {
				
				$method = $blockchain['name'];
				$fee = $blockchain['fee'];
				$fee_fix = $blockchain['fee_fix'];
				$minimum = $blockchain['minimum_'.$currency.''];
				$maximum = $blockchain['maximum_'.$currency.''];
				$code_method = "blockchain";
				
				if ($blockchain['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($blockchain['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($blockchain['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}
				
				// Check currency and account for receiving deposits
				if ($currency == "debit_base" && $blockchain['debit_base'] == "1") {
					$merchant_account = $blockchain['ac_debit_base'];
				} elseif ($currency == "debit_extra1" && $blockchain['debit_extra1'] == "1") {
					$merchant_account = $blockchain['ac_debit_extra1'];
				} elseif ($currency == "debit_extra2" && $blockchain['debit_extra2'] == "1") {
					$merchant_account = $blockchain['ac_debit_extra2'];
				} elseif ($currency == "debit_extra3" && $blockchain['debit_extra3'] == "1") {
					$merchant_account = $blockchain['ac_debit_extra3'];
				} elseif ($currency =="debit_extra4" && $blockchain['debit_extra4'] == "1") {
					$merchant_account = $blockchain['ac_debit_extra4'];
				} elseif ($currency =="debit_extra5" && $blockchain['debit_extra5'] == "1") {
					$merchant_account = $blockchain['ac_debit_extra5'];
				}	else {
					
					$this->session->set_flashdata('error', lang('users deposit error_5'));
					redirect(site_url("account/deposit"));
					
				}
				
			}
			
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
			
			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_fee = number_format($total_fee_calc, 2, '.', '');
			$total_amount_calc = $amount + $total_fee;
			$total_amount = number_format($total_amount_calc, 2, '.', '');
			
			// Check verify status
			if ($verify_status == FALSE) {
				
				$this->session->set_flashdata('error', lang('users deposit error_4'));
				redirect(site_url("account/deposit"));
				
			}
			
			// Check amount for minimum and maximum limits
			if ($minimum > $amount) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/deposit"));
				
			} elseif ($maximum < $amount) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/deposit"));
				
			}
			
			
			// setup page header data
			$this->set_title(sprintf(lang('users dashboard deposit'), $this->settings->site_name));

			$data = $this->includes;

			// set content data
			$content_data = array(
				'user'              => $user,
				'total_amount'              => $total_amount,
				'total_fee'              => $total_fee,
				'amount'              => $amount,
				'currency'              => $currency,
				'method'              => $method,
				'account'              => $account,
				'terms'              => $terms,
				'code_method'              => $code_method,
				'account'              => $account,
				'merchant_account'     => $merchant_account,
				'advcash'     => $advcash,
				'payeer'     => $payeer,
				'skrill'     => $skrill,
				'swift'     => $swift,
				'local_bank'     => $local_bank,
				'coinpayments'     => $coinpayments,
				'blockchain'     => $blockchain,
				'symbol'     => $symbol,
			 );

			// load views
			$data['content'] = $this->load->view('account/deposit/confirm', $content_data, TRUE);
			$this->load->view($this->template, $data);
			
		}
		
	}
	
	function credit_card()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$skrill = $this->settings_model->get_dep_method(5);
		$paygol = $this->settings_model->get_dep_method(6);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric');
		$this->form_validation->set_rules('method', lang('users withdrawal method'), 'required|trim|in_list[skrill,paygol]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users withdrawal error_1'));
			redirect(site_url("account/deposit"));
			
		} else {
			
			$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
			$currency = $this->input->post("currency", TRUE);
			$code_method = $this->input->post("method", TRUE);
			
			if ($code_method == "skrill") {
				
				$method = $skrill['name'];
				$fee = $skrill['fee'];
				$fee_fix = $skrill['fee_fix'];
				$minimum = $skrill['minimum_'.$currency.''];
				$maximum = $skrill['maximum_'.$currency.''];;

				$random = rand(100000000000, 900000000000);
				$unic = uniqid();
				$id_transaction = ''.$random.'-'.$unic.'';

				if ($skrill['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($skrill['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($skrill['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}

				// Check currency and account for receiving deposits
				if ($currency == "debit_base") {
					$merchant_account = $skrill['ac_debit_base'];
					$symbol = $this->currencys->display->base_code;
				} elseif ($currency == "debit_extra1") {
					$merchant_account = $skrill['ac_debit_extra1'];
					$symbol = $this->currencys->display->extra1_code;
				} elseif ($currency == "debit_extra2") {
					$merchant_account = $skrill['ac_debit_extra2'];
					$symbol = $this->currencys->display->extra2_code;
				} elseif ($currency == "debit_extra3") {
					$merchant_account = $skrill['ac_debit_extra3'];
					$symbol = $this->currencys->display->extra3_code;
				} elseif ($currency =="debit_extra4") {
					$merchant_account = $skrill['ac_debit_extra4'];
					$symbol = $this->currencys->display->extra4_code;
				} elseif ($currency =="debit_extra5") {
					$merchant_account = $skrill['ac_debit_extra5'];
					$symbol = $this->currencys->display->extra5_code;
				}
				
			} elseif ($code_method == "paygol") {
				
				$method = $paygol['name'];
				$fee = $paygol['fee'];
				$fee_fix = $paygol['fee_fix'];
				$minimum = $paygol['minimum_'.$currency.''];
				$maximum = $paygol['maximum_'.$currency.''];;

				$random = rand(100000000000, 900000000000);
				$unic = uniqid();
				$id_transaction = ''.$random.'-'.$unic.'';

				if ($paygol['start_verify'] == "1" && $user['verify_status'] == 0) {
					$verify_status = TRUE;
				} elseif ($paygol['standart_verify'] == "1" && $user['verify_status'] == 1) {
					$verify_status = TRUE;
				} elseif ($paygol['expanded_verify'] == "1" && $user['verify_status'] == 2) {
					$verify_status = TRUE;
				} else {
					$verify_status = FALSE;
				}

				// Check currency and account for receiving deposits
				if ($currency == "debit_base") {
					$merchant_account = $paygol['ac_debit_base'];
					$symbol = $this->currencys->display->base_code;
				} elseif ($currency == "debit_extra1") {
					$merchant_account = $paygol['ac_debit_extra1'];
					$symbol = $this->currencys->display->extra1_code;
				} elseif ($currency == "debit_extra2") {
					$merchant_account = $paygol['ac_debit_extra2'];
					$symbol = $this->currencys->display->extra2_code;
				} elseif ($currency == "debit_extra3") {
					$merchant_account = $paygol['ac_debit_extra3'];
					$symbol = $this->currencys->display->extra3_code;
				} elseif ($currency =="debit_extra4") {
					$merchant_account = $paygol['ac_debit_extra4'];
					$symbol = $this->currencys->display->extra4_code;
				} elseif ($currency =="debit_extra5") {
					$merchant_account = $paygol['ac_debit_extra5'];
					$symbol = $this->currencys->display->extra5_code;
				}
				
			}
			
			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_fee = number_format($total_fee_calc, 2, '.', '');
			$total_amount_calc = $amount + $total_fee;
			$total_amount = number_format($total_amount_calc, 2, '.', '');
			
			// Check verify status
			if ($verify_status == FALSE) {
				
				$this->session->set_flashdata('error', lang('users deposit error_4'));
				redirect(site_url("account/deposit"));
				
			}
			
			// Check amount for minimum and maximum limits
			if ($minimum > $amount) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/deposit"));
				
			} elseif ($maximum < $amount) {
				
				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/deposit"));
				
			}
			
		}
		
		// setup page header data
		$this->set_title(sprintf(lang('users dashboard deposit'), $this->settings->site_name));

		$data = $this->includes;
		
		// set content data
		$content_data = array(
			'user'    => $user,
			'total_amount'              => $total_amount,
			'total_fee'              => $total_fee,
			'amount'              => $amount,
			'currency'              => $currency,
			'method'              => $method,
			'code_method'              => $code_method,
			'merchant_account'     => $merchant_account,
			'skrill'     => $skrill,
			'paygol'     => $paygol,
			'symbol'     => $symbol,
			'id_transaction'     => $id_transaction,
		);
		
		// load views
		$data['content'] = $this->load->view('account/deposit/credit_card', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	function bank()
	{
		
		$user = $this->users_model->get_user($this->user['id']);

		$swift = $this->settings_model->get_dep_method(7);
		$local_bank = $this->settings_model->get_dep_method(8);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric');
		$this->form_validation->set_rules('method', lang('users withdrawal method'), 'required|trim|in_list[swift,local_bank]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users withdrawal error_1'));
			redirect(site_url("account/deposit"));
			
		} else {
			
			$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
			$currency = $this->input->post("currency", TRUE);
			$code_method = $this->input->post("method", TRUE);
			
				if ($code_method == "swift") {

					$method = $swift['name'];
					$fee = $swift['fee'];
					$fee_fix = $swift['fee_fix'];
					$minimum = $swift['minimum_'.$currency.''];
					$maximum = $swift['maximum_'.$currency.''];;

					$random = rand(100000000000, 900000000000);
					$unic = uniqid();
					$id_transaction = ''.$random.'-'.$unic.'';

					if ($swift['start_verify'] == "1" && $user['verify_status'] == 0) {
						$verify_status = TRUE;
					} elseif ($swift['standart_verify'] == "1" && $user['verify_status'] == 1) {
						$verify_status = TRUE;
					} elseif ($swift['expanded_verify'] == "1" && $user['verify_status'] == 2) {
						$verify_status = TRUE;
					} else {
						$verify_status = FALSE;
					}

					// Check currency and account for receiving deposits
					if ($currency == "debit_base") {
						$merchant_account = $swift['ac_debit_base'];
						$symbol = $this->currencys->display->base_code;
					} elseif ($currency == "debit_extra1") {
						$merchant_account = $swift['ac_debit_extra1'];
						$symbol = $this->currencys->display->extra1_code;
					} elseif ($currency == "debit_extra2") {
						$merchant_account = $swift['ac_debit_extra2'];
						$symbol = $this->currencys->display->extra2_code;
					} elseif ($currency == "debit_extra3") {
						$merchant_account = $swift['ac_debit_extra3'];
						$symbol = $this->currencys->display->extra3_code;
					} elseif ($currency =="debit_extra4") {
						$merchant_account = $swift['ac_debit_extra4'];
						$symbol = $this->currencys->display->extra4_code;
					} elseif ($currency =="debit_extra5") {
						$merchant_account = $swift['ac_debit_extra5'];
						$symbol = $this->currencys->display->extra5_code;
					}

				} elseif ($code_method == "local_bank") {
					
					$method = $local_bank['name'];
					$fee = $local_bank['fee'];
					$fee_fix = $local_bank['fee_fix'];
					$minimum = $local_bank['minimum_'.$currency.''];
					$maximum = $local_bank['maximum_'.$currency.''];;

					$random = rand(100000000000, 900000000000);
					$unic = uniqid();
					$id_transaction = ''.$random.'-'.$unic.'';

					if ($local_bank['start_verify'] == "1" && $user['verify_status'] == 0) {
						$verify_status = TRUE;
					} elseif ($local_bank['standart_verify'] == "1" && $user['verify_status'] == 1) {
						$verify_status = TRUE;
					} elseif ($local_bank['expanded_verify'] == "1" && $user['verify_status'] == 2) {
						$verify_status = TRUE;
					} else {
						$verify_status = FALSE;
					}

					// Check currency and account for receiving deposits
					if ($currency == "debit_base") {
						$merchant_account = $local_bank['ac_debit_base'];
						$symbol = $this->currencys->display->base_code;
					} elseif ($currency == "debit_extra1") {
						$merchant_account = $local_bank['ac_debit_extra1'];
						$symbol = $this->currencys->display->extra1_code;
					} elseif ($currency == "debit_extra2") {
						$merchant_account = $local_bank['ac_debit_extra2'];
						$symbol = $this->currencys->display->extra2_code;
					} elseif ($currency == "debit_extra3") {
						$merchant_account = $local_bank['ac_debit_extra3'];
						$symbol = $this->currencys->display->extra3_code;
					} elseif ($currency =="debit_extra4") {
						$merchant_account = $local_bank['ac_debit_extra4'];
						$symbol = $this->currencys->display->extra4_code;
					} elseif ($currency =="debit_extra5") {
						$merchant_account = $local_bank['ac_debit_extra5'];
						$symbol = $this->currencys->display->extra5_code;
					}
					
				}
			
				// Calculation of the commission and total sum
				$percent = $fee/"100";
				$percent_fee = $amount * $percent;
				$total_fee_calc = $percent_fee + $fee_fix;
				$total_fee = number_format($total_fee_calc, 2, '.', '');
				$total_amount_calc = $amount + $total_fee;
				$total_amount = number_format($total_amount_calc, 2, '.', '');
			
				$label = uniqid("bmt_");

				// Check verify status
				if ($verify_status == FALSE) {

					$this->session->set_flashdata('error', lang('users deposit error_4'));
					redirect(site_url("account/deposit"));

				}

				// Check amount for minimum and maximum limits
				if ($minimum > $amount) {

					$this->session->set_flashdata('error', lang('users withdrawal error_3'));
					redirect(site_url("account/deposit"));

				} elseif ($maximum < $amount) {

					$this->session->set_flashdata('error', lang('users withdrawal error_3'));
					redirect(site_url("account/deposit"));

				}
			
				if ($code_method == "swift") {
					
					// add new transaction
					$transactions = $this->transactions_model->add_transaction(array(
						"type" 				=> "1",
						"sum"  				=> $total_amount_calc,
						"fee"    			=> $total_fee_calc,
						"amount" 			=> $amount,
						"currency"		=> $currency,
						"status" 			=> "1",
						"sender" 			=> $swift['name'],
						"receiver" 		=> $user['username'],
						"time"        => date('Y-m-d H:i:s'),
						"label" 	    => $label,
						"admin_comment" 	    => 'none',
						"user_comment" 	    => ''.$merchant_account.'<br><strong> Note for bank transfer:'.$id_transaction.'</strong>',
						"ip_address" 	    =>  $_SERVER["REMOTE_ADDR"],
						"protect" 	    => "none",
						)
					);
					
				} else {
					
					// add new transaction
					$transactions = $this->transactions_model->add_transaction(array(
						"type" 				=> "1",
						"sum"  				=> $total_amount_calc,
						"fee"    			=> $total_fee_calc,
						"amount" 			=> $amount,
						"currency"		=> $currency,
						"status" 			=> "1",
						"sender" 			=> $local_bank['name'],
						"receiver" 		=> $user['username'],
						"time"        => date('Y-m-d H:i:s'),
						"label" 	    => $label,
						"admin_comment" 	    => 'none',
						"user_comment" 	    => ''.$merchant_account.'<br><strong> Note for bank transfer:'.$id_transaction.'</strong>',
						"ip_address" 	    =>  $_SERVER["REMOTE_ADDR"],
						"protect" 	    => "none",
						)
					);
					
				}
			
		}
		
		// setup page header data
		$this->set_title(sprintf(lang('users dashboard deposit'), $this->settings->site_name));

		$data = $this->includes;
		
		// set content data
		$content_data = array(
			'user'    => $user,
			'total_amount'              => $total_amount,
			'total_fee'              => $total_fee,
			'amount'              => $amount,
			'currency'              => $currency,
			'method'              => $method,
			'code_method'              => $code_method,
			'merchant_account'     => $merchant_account,
			'swift'     => $skrill,
			'local_bank'     => $local_bank,
			'symbol'     => $symbol,
			'id_transaction'     => $id_transaction,
		);
		
		// load views
		$data['content'] = $this->load->view('account/deposit/bank', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	/**
    * BlockChain
    */
	function blockchain()
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$blockchain = $this->settings_model->get_dep_method(10);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric');
		$this->form_validation->set_rules('method', lang('users withdrawal method'), 'required|trim|in_list[blockchain]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users withdrawal error_1'));
			redirect(site_url("account/deposit"));
			
		} else {
			
			$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
			$currency = $this->input->post("currency", TRUE);
			$code_method = $this->input->post("method", TRUE);
			
			$method = $blockchain['name'];
			$fee = $blockchain['fee'];
			$fee_fix = $blockchain['fee_fix'];
			$minimum = $blockchain['minimum_'.$currency.''];
			$maximum = $blockchain['maximum_'.$currency.''];;

			$random = rand(100000000000, 900000000000);
			$unic = uniqid();
			$id_transaction = ''.$random.'-'.$unic.'';

			if ($blockchain['start_verify'] == "1" && $user['verify_status'] == 0) {
				$verify_status = TRUE;
			} elseif ($blockchain['standart_verify'] == "1" && $user['verify_status'] == 1) {
				$verify_status = TRUE;
			} elseif ($blockchain['expanded_verify'] == "1" && $user['verify_status'] == 2) {
				$verify_status = TRUE;
			} else {
				$verify_status = FALSE;
			}

			// Check currency and account for receiving deposits
			if ($currency == "debit_base") {
				$merchant_account = $blockchain['ac_debit_base'];
				$symbol = $this->currencys->display->base_code;
			} elseif ($currency == "debit_extra1") {
				$merchant_account = $blockchain['ac_debit_extra1'];
				$symbol = $this->currencys->display->extra1_code;
			} elseif ($currency == "debit_extra2") {
				$merchant_account = $blockchain['ac_debit_extra2'];
				$symbol = $this->currencys->display->extra2_code;
			} elseif ($currency == "debit_extra3") {
				$merchant_account = $blockchain['ac_debit_extra3'];
				$symbol = $this->currencys->display->extra3_code;
			} elseif ($currency =="debit_extra4") {
				$merchant_account = $blockchain['ac_debit_extra4'];
				$symbol = $this->currencys->display->extra4_code;
			} elseif ($currency =="debit_extra5") {
				$merchant_account = $blockchain['ac_debit_extra5'];
				$symbol = $this->currencys->display->extra5_code;
			}
			
			// Calculation of the commission and total sum
			$percent = $fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $fee_fix;
			$total_fee = number_format($total_fee_calc, 2, '.', '');
			$total_amount_calc = $amount + $total_fee;
			$total_amount = number_format($total_amount_calc, 2, '.', '');
			
			$label = uniqid("blc_");

			// Check verify status
			if ($verify_status == FALSE) {

				$this->session->set_flashdata('error', lang('users deposit error_4'));
				redirect(site_url("account/deposit"));

			}

			// Check amount for minimum and maximum limits
			if ($minimum > $amount) {

				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/deposit"));

			} elseif ($maximum < $amount) {

				$this->session->set_flashdata('error', lang('users withdrawal error_3'));
				redirect(site_url("account/deposit"));

			}
			
			$my_callback_url = ''.base_url().'ipn/blockchain?secret='.$blockchain['api_value2'];
				
			$call_url = urlencode($my_callback_url);

			$root_url = 'https://api.blockchain.info/v2/receive';

			$parameters = 'xpub='.$merchant_account.'&callback='.urlencode($my_callback_url).'&key='.$blockchain['api_value1'];

			$response = file_get_contents($root_url.'?'.$parameters);

			$object = json_decode($response);

			$forwarding_address = $object->address;
			
			if ($forwarding_address) {
				
				$qr_img = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=bitcoin:'.$forwarding_address.'';
				
				// check value BTC
				$btc_value = $this->fixer->get_btc_rates($symbol, $total_amount);
				
				// add new transaction
				$transactions = $this->transactions_model->add_transaction(array(
					"type" 				=> "1",
					"sum"  				=> $total_amount_calc,
					"fee"    			=> $total_fee_calc,
					"amount" 			=> $amount,
					"currency"		=> $currency,
					"status" 			=> "1",
					"sender" 			=> $blockchain['name'],
					"receiver" 		=> $user['username'],
					"time"        => date('Y-m-d H:i:s'),
					"label" 	    => $label,
					"admin_comment" 	    => 'none',
					"user_comment" 	    => $forwarding_address,
					"ip_address" 	    =>  $_SERVER["REMOTE_ADDR"],
					"protect" 	    => "none",
					)
				);
				
			} else {
				
				$this->session->set_flashdata('error', lang('users deposit error_6'));
				redirect(site_url("account/deposit"));
				
			}
			
		}
		
		// setup page header data
		$this->set_title(sprintf(lang('users dashboard deposit'), $this->settings->site_name));

		$data = $this->includes;
		
		// set content data
		$content_data = array(
			'user'    => $user,
			'total_amount'              => $total_amount,
			'total_fee'              => $total_fee,
			'amount'              => $amount,
			'currency'              => $currency,
			'method'              => $method,
			'code_method'              => $code_method,
			'merchant_account'     => $merchant_account,
			'blockchain'     => $blockchain,
			'symbol'     => $symbol,
			'forwarding_address'     => $forwarding_address,
			'qr_img'     => $qr_img,
			'btc_value'     => $btc_value,
		);
		
		// load views
		$data['content'] = $this->load->view('account/deposit/blockchain', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
  
}