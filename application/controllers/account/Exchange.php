<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange extends Private_Controller {

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
	 * Default
     */
	function index()
	{
				$user = $this->users_model->get_user($this->user['id']);
		
        // setup page header data
        $this->set_title(sprintf(lang('users menu exchange'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
					'user'              => $user,
        );

        // load views
        $data['content'] = $this->load->view('account/exchange/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	function calculation()
	{
		
		// setup page header data
    $this->set_title(sprintf(lang('users menu exchange'), $this->settings->site_name));
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users error form'));
			redirect(site_url("account/exchange"));
			
		} else {
			
			$amount = $this->input->post("amount", TRUE);
			$currency = $this->input->post("currency", TRUE);
			$main_currency = "debit_base";
			$percent = $this->currencys->display->fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee = $percent_fee + $this->currencys->display->fee_fix;
			$type = "1";
			
			// Check rate
			if ($currency == "debit_extra1") {
				
				if($this->currencys->display->api_extra1 == "0") {
					
					$rates = $this->currencys->display->extra1_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra1_code);
					
				}
				
			} elseif ($currency == "debit_extra2") {
				
				if($this->currencys->display->api_extra2 == "0") {
					
					$rates = $this->currencys->display->extra2_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra2_code);
					
				}
				
			} elseif ($currency == "debit_extra3") {
				
				if($this->currencys->display->api_extra3 == "0") {
					
					$rates = $this->currencys->display->extra3_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra3_code);
					
				}
				
			} elseif ($currency == "debit_extra4") {
				
				if($this->currencys->display->api_extra4 == "0") {
					
					$rates = $this->currencys->display->extra4_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra4_code);
					
				}
				
			} elseif ($currency == "debit_extra5") {
				
				if($this->currencys->display->api_extra5 == "0") {
					
					$rates = $this->currencys->display->extra5_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra5_code);
					
				}
				
			}
			
			$total_give = $amount + $total_fee;
			
			$total = $amount*$rates;
			
			// new number format
			$rates_final = number_format($rates, 2, '.', '');
			$amount_final = number_format($amount, 2, '.', '');
			$total_final = number_format($total, 2, '.', '');
			$total_fee_final = number_format($total_fee, 2, '.', '');
			$total_give_final = number_format($total_give, 2, '.', '');
			
		}	
		
		$data = $this->includes;
	
		// set content data
		$content_data = array(
			'amount'    => $amount_final,
			'currency'  => $currency,
			'main_currency'  => $main_currency,
			'rates'  => $rates_final,
			'total_fee'  => $total_fee_final,
			'total'  => $total_final,
			'user'  => $user,
			'total_give'  => $total_give_final,
			'type'  => $type,
		);

		// load views
		$data['content'] = $this->load->view('account/exchange/calculation', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	function calculation_to()
	{
		
		// setup page header data
    $this->set_title(sprintf(lang('users menu exchange'), $this->settings->site_name));
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users error form'));
			redirect(site_url("account/exchange"));
			
		} else {
			
			$amount = $this->input->post("amount", TRUE);
			$currency = "debit_base";
			$main_currency = $this->input->post("currency", TRUE);
			$percent = $this->currencys->display->fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee = $percent_fee + $this->currencys->display->fee_fix;
			$type = "2";
			
			// Check rate
			if ($main_currency == "debit_extra1") {
				
				if($this->currencys->display->api_extra1 == "0") {
					
					$rates = $this->currencys->display->extra1_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra1_code);
					
				}
				
			} elseif ($main_currency == "debit_extra2") {
				
				if($this->currencys->display->api_extra2 == "0") {
					
					$rates = $this->currencys->display->extra2_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra2_code);
					
				}
				
			} elseif ($main_currency == "debit_extra3") {
				
				if($this->currencys->display->api_extra3 == "0") {
					
					$rates = $this->currencys->display->extra3_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra3_code);
					
				}
				
			} elseif ($main_currency == "debit_extra4") {
				
				if($this->currencys->display->api_extra4 == "0") {
					
					$rates = $this->currencys->display->extra4_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra4_code);
					
				}
				
			} elseif ($main_currency == "debit_extra5") {
				
				if($this->currencys->display->api_extra5 == "0") {
					
					$rates = $this->currencys->display->extra5_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra5_code);
					
				}
				
			}
			
			$total_give = $amount + $total_fee;
			
			$total = $amount/$rates;
			
			// new number format
			$rates_final = number_format($rates, 2, '.', '');
			$amount_final = number_format($amount, 2, '.', '');
			$total_final = number_format($total, 2, '.', '');
			$total_fee_final = number_format($total_fee, 2, '.', '');
			$total_give_final = number_format($total_give, 2, '.', '');
			
		}	
		
		$data = $this->includes;
	
		// set content data
		$content_data = array(
			'amount'    => $amount_final,
			'currency'  => $main_currency,
			'main_currency'  => $currency,
			'rates'  => $rates_final,
			'total_fee'  => $total_fee_final,
			'total'  => $total_final,
			'user'  => $user,
			'total_give'  => $total_give_final,
			'type'  => $type,
		);

		// load views
		$data['content'] = $this->load->view('account/exchange/calculation', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	function exchange_of_base()
	{
		
		// setup page header data
    $this->set_title(sprintf(lang('users menu exchange'), $this->settings->site_name));
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users error form'));
			redirect(site_url("account/exchange"));
			
		} else {
			
			$amount = $this->input->post("amount", TRUE);
			$currency = $this->input->post("currency", TRUE);
			$main_currency = "debit_base";
			$percent = $this->currencys->display->fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee = $percent_fee + $this->currencys->display->fee_fix;
			$type = "1";
			
			// Check rate
			if ($currency == "debit_extra1") {
				
				if($this->currencys->display->api_extra1 == "0") {
					
					$rates = $this->currencys->display->extra1_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra1_code);
					
				}
				
			} elseif ($currency == "debit_extra2") {
				
				if($this->currencys->display->api_extra2 == "0") {
					
					$rates = $this->currencys->display->extra2_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra2_code);
					
				}
				
			} elseif ($currency == "debit_extra3") {
				
				if($this->currencys->display->api_extra3 == "0") {
					
					$rates = $this->currencys->display->extra3_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra3_code);
					
				}
				
			} elseif ($currency == "debit_extra4") {
				
				if($this->currencys->display->api_extra4 == "0") {
					
					$rates = $this->currencys->display->extra4_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra4_code);
					
				}
				
			} elseif ($currency == "debit_extra5") {
				
				if($this->currencys->display->api_extra5 == "0") {
					
					$rates = $this->currencys->display->extra5_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra5_code);
					
				}
				
			}
			
			$total_give = $amount + $total_fee;
			
			$total = $amount*$rates;

			// Check wallet
			if ($user['debit_base'] < $total_give) {

				$this->session->set_flashdata('error', lang('users error wallet'));
				redirect(site_url("account/exchange"));

			} else {
				
				$total_wallet_exchange = $user[$currency] + $total;
				$base_wallet = $user['debit_base'] - $total_give;
				
				$hold_balance = $this->transactions_model->hold_balance($user['username'], 'debit_base');
				
				// check user hold balance
				if ($base_wallet < $hold_balance) {
						
					$this->session->set_flashdata('error', lang('users error wallet'));
					redirect(site_url("account/money_transfer"));
						
				} else {
					
					$label = uniqid("exw_");
					$label2 = uniqid("exd_");

					// update user wallet - get
					$this->users_model->update_wallet_transfer($user['username'],
						array(
							$currency => $total_wallet_exchange,
						)
					);

					// update user wallet - base wallet
					$this->users_model->update_wallet_transfer($user['username'],
						array(
							"debit_base" => $base_wallet,
							)
					);

					// add new transaction exchange
					$transactions = $this->transactions_model->add_transaction(array(
						"type" 				=> "4",
						"sum"  				=> $total_give,
						"fee"    			=> $total_fee,
						"amount" 			=> $amount,
						"currency"		=> "debit_base",
						"status" 			=> "2",
						"sender" 			=> $user['username'],
						"receiver" 		=> "system",
						"time"        => date('Y-m-d H:i:s'),
						"label" 	    => $label,
						"ip_address" 	=> $_SERVER["REMOTE_ADDR"],
						"protect" 	  => "none",
						)
					);

					// check transaction for comment deposit transaction
					$transaction_exchange = $this->transactions_model->get_label($label);

					// add new transaction deposit
					$transactions = $this->transactions_model->add_transaction(array(
						"type" 				=> "1",
						"sum"  				=> $total,
						"fee"    			=> "0.00",
						"amount" 			=> $total,
						"currency"		=> $currency,
						"status" 			=> "2",
						"sender" 			=> "system",
						"receiver" 		=> $user['username'],
						"time"        => date('Y-m-d H:i:s'),
						"label" 	    => $label2,
						"user_comment"  	=> 'Exchange transaction ID '.$transaction_exchange['id'].'',
						"ip_address" 	=> $_SERVER["REMOTE_ADDR"],
						"protect" 	  => "none",
						)
					);
					
					$email_template = $this->template_model->get_email_template(11);
				
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
						$total_mail = number_format($total, 2, '.', '');
						$total_amount = number_format($amount, 2, '.', '');

						$rawstring = $email_template['message'];

						// what will we replace
						$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[SUM_1]','[CUR_1]','[SUM_2]','[CUR_2]');

						$vals_1 = array($site_name, $link, $name_user, $total_amount, $this->currencys->display->base_code, $total_mail, $symbol);

						//replace
						$str_1 = str_replace($placeholders, $vals_1, $rawstring);

						$this -> email -> from($this->settings->site_email, $this->settings->site_name);
						$this->email->to($user['email']);
						//$this -> email -> to($user['email']);
						$this -> email -> subject($email_template['title']);

						$this -> email -> message($str_1);

						$this->email->send();

					}
					
					$sms_template = $this->template_model->get_sms_template(9);
							
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
										
										$total_mail = number_format($total, 2, '.', '');
										$total_amount = number_format($amount, 2, '.', '');
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[SUM_1]','[CUR_1]','[SUM_2]','[CUR_2]');

										$vals_1 = array($total_amount, $this->currencys->display->base_code, $total_mail, $symbol);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}

					$this->session->set_flashdata('message', lang('users exchange success'));
					redirect(site_url("account/transactions"));
					
				}
				
			}
			
		}

	}
	
	function exchange_to_base()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users error form'));
			redirect(site_url("account/exchange"));
			
		} else {
			
			$amount = $this->input->post("amount", TRUE);
			$currency = "debit_base";
			$main_currency = $this->input->post("currency", TRUE);
			$percent = $this->currencys->display->fee/"100";
			$percent_fee = $amount * $percent;
			$total_fee = $percent_fee + $this->currencys->display->fee_fix;
			$type = "2";
			
			// Check rate
			if ($main_currency == "debit_extra1") {
				
				if($this->currencys->display->api_extra1 == "0") {
					
					$rates = $this->currencys->display->extra1_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra1_code);
					
				}
				
			} elseif ($main_currency == "debit_extra2") {
				
				if($this->currencys->display->api_extra2 == "0") {
					
					$rates = $this->currencys->display->extra2_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra2_code);
					
				}
				
			} elseif ($main_currency == "debit_extra3") {
				
				if($this->currencys->display->api_extra3 == "0") {
					
					$rates = $this->currencys->display->extra3_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra3_code);
					
				}
				
			} elseif ($main_currency == "debit_extra4") {
				
				if($this->currencys->display->api_extra4 == "0") {
					
					$rates = $this->currencys->display->extra4_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra4_code);
					
				}
				
			} elseif ($main_currency == "debit_extra5") {
				
				if($this->currencys->display->api_extra5 == "0") {
					
					$rates = $this->currencys->display->extra5_rate;
					
				} else {
					
					$rates = $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra5_code);
					
				}
				
			}
			
			$total_give = $amount + $total_fee;
			
			$total = $amount/$rates;
			
			$base_wallet = $user['debit_base'] + $total;
			$extra_wallet = $user[$main_currency] - $total_give;
			
			$hold_balance = $this->transactions_model->hold_balance($user['username'], $main_currency);
			
			// check user hold balance
			if ($extra_wallet < $hold_balance) {
						
				$this->session->set_flashdata('error', lang('users error wallet'));
				redirect(site_url("account/exchange"));
						
			} else {
				
				// Check wallet
				if ($user[$main_currency]<$amount) {

					$this->session->set_flashdata('error', lang('users error wallet'));
					redirect(site_url("account/exchange"));

				} else {

					$label = uniqid("exw_");
					$label2 = uniqid("exd_");

					// update user wallet - get
					$this->users_model->update_wallet_transfer($user['username'],
						array(
							'debit_base' => $base_wallet,
						)
					);

					// update user wallet - base wallet
					$this->users_model->update_wallet_transfer($user['username'],
						array(
							$main_currency => $extra_wallet,
						)
					);

					$transactions = $this->transactions_model->add_transaction(array(
						"type" 				=> "4",
						"sum"  				=> $total_give,
						"fee"    			=> $total_fee,
						"amount" 			=> $amount,
						"currency"		=> $main_currency,
						"status" 			=> "2",
						"sender" 			=> $user['username'],
						"receiver" 		=> "system",
						"time"        => date('Y-m-d H:i:s'),
						"label" 	    => $label,
						"ip_address" 	=> $_SERVER["REMOTE_ADDR"],
						"protect" 	  => "none",
						)
					);

					// check transaction for comment deposit transaction
					$transaction_exchange = $this->transactions_model->get_label($label);

					// add new transaction deposit
					$transactions = $this->transactions_model->add_transaction(array(
						"type" 				=> "1",
						"sum"  				=> $total,
						"fee"    			=> "0.00",
						"amount" 			=> $total,
						"currency"		=> "debit_base",
						"status" 			=> "2",
						"sender" 			=> "system",
						"receiver" 		=> $user['username'],
						"time"        => date('Y-m-d H:i:s'),
						"label" 	    => $label2,
						"user_comment"  	=> 'Exchange transaction ID '.$transaction_exchange['id'].'',
						"ip_address" 	=> $_SERVER["REMOTE_ADDR"],
						"protect" 	  => "none",
						)
					);
					
					$email_template = $this->template_model->get_email_template(11);
				
					if($email_template['status'] == "1") {
						
						// Check currency
						if ($main_currency == "debit_base") {
							$symbol = $this->currencys->display->base_code;
						} elseif ($main_currency == "debit_extra1") {
							$symbol = $this->currencys->display->extra1_code;
						} elseif ($main_currency == "debit_extra2") {
							$symbol = $this->currencys->display->extra2_code;
						} elseif ($main_currency == "debit_extra3") {
							$symbol = $this->currencys->display->extra3_code;
						} elseif ($main_currency =="debit_extra4") {
							$symbol = $this->currencys->display->extra4_code;
						} elseif ($main_currency =="debit_extra5") {
							$symbol = $this->currencys->display->extra5_code;
						}

						// variables to replace
						$site_name = $this->settings->site_name;
						$link = site_url('account/transactions');
						$name_user = $user['first_name'] . ' ' . $user['last_name'];
						$total_mail = number_format($total, 2, '.', '');
						$total_amount = number_format($amount, 2, '.', '');

						$rawstring = $email_template['message'];

						// what will we replace
						$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[SUM_1]','[CUR_1]','[SUM_2]','[CUR_2]');

						$vals_1 = array($site_name, $link, $name_user, $total_amount, $symbol, $total_mail, $this->currencys->display->base_code);

						//replace
						$str_1 = str_replace($placeholders, $vals_1, $rawstring);

						$this -> email -> from($this->settings->site_email, $this->settings->site_name);
						$this->email->to($user['email']);
						//$this -> email -> to($user['email']);
						$this -> email -> subject($email_template['title']);

						$this -> email -> message($str_1);

						$this->email->send();

					}
					
					$sms_template = $this->template_model->get_sms_template(9);
							
									if($sms_template['status'] == "1") {
										
										// Check currency
										if ($main_currency == "debit_base") {
											$symbol = $this->currencys->display->base_code;
										} elseif ($main_currency == "debit_extra1") {
											$symbol = $this->currencys->display->extra1_code;
										} elseif ($main_currency == "debit_extra2") {
											$symbol = $this->currencys->display->extra2_code;
										} elseif ($main_currency == "debit_extra3") {
											$symbol = $this->currencys->display->extra3_code;
										} elseif ($main_currency =="debit_extra4") {
											$symbol = $this->currencys->display->extra4_code;
										} elseif ($main_currency =="debit_extra5") {
											$symbol = $this->currencys->display->extra5_code;
										}
										
										$total_mail = number_format($total, 2, '.', '');
										$total_amount = number_format($amount, 2, '.', '');
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[SUM_1]','[CUR_1]','[SUM_2]','[CUR_2]');

										$vals_1 = array($total_amount, $symbol, $total_mail, $this->currencys->display->base_code);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}

					$this->session->set_flashdata('message', lang('users exchange success'));
					redirect(site_url("account/transactions"));

				}
				
			}
			
		}

	}
	
  
}