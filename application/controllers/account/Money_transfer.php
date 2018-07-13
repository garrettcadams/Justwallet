<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Money_transfer extends Private_Controller {

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
				$this->load->library('notice');
    }
  
        /**
     * Default
       */
    function index()
    {
          $user = $this->users_model->get_user($this->user['id']);
      
          $percent = $this->settings->com_transfer;
		      $fee = $this->settings->com_transfer/"100";

          // setup page header data
          $this->set_title(sprintf(lang('users menu transfer'), $this->settings->site_name));

          $data = $this->includes;

          // set content data
          $content_data = array(
            'user'              => $user,
            'percent'     	=> $percent,
			      'fee'     		=> $fee,
          );

          // load views
          $data['content'] = $this->load->view('account/money_transfer/index', $content_data, TRUE);
      $this->load->view($this->template, $data);
    }
  
  /**
    * Start transfer money
    */
	function start_transfer()
	{	
		// get the data
        $user = $this->users_model->get_user($this->user['id']);
					
				$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
				$this->form_validation->set_rules('receiver', lang('users transfer user_mail'), 'required|trim|callback__check_username[]');
				$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
				$this->form_validation->set_rules('code_protect', lang('users transfer code_protect'), 'trim|numeric|max_length[4]|min_length[4]');
    
				if ($this->form_validation->run() == FALSE)
					{
						$this->session->set_flashdata('error', lang('users error form'));
						redirect(site_url("account/money_transfer"));
					}
					else
					{
							
					$amount = $this->input->post("amount", TRUE);
					$currency = $this->input->post("currency", TRUE);
					$receiver = $this->input->post("receiver", TRUE);
          $note = $this->input->post("note", TRUE);
					$code_protect = $this->input->post("code_protect", TRUE);
          
          // check protect mode
          if ($code_protect != NULL) {
            $protect = $code_protect;
            $status = "1";
          } else {
            $protect = "none";
            $status = "2";
          }

					$user_receiver = $this->users_model->get_username($receiver);
							
					$percent = $this->settings->com_transfer/"100";
					$fee = $amount*$percent;
					$sum = $fee+$amount;

					$total_receiver = $user_receiver[$currency]+$amount;
					$total_sender = $user[$currency]-$sum;
					$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);

					// check user hold balance
					if ($total_sender < $hold_balance) {
						
						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url("account/money_transfer"));
						
					} else {
						
						// Check wallet
						if ($user[$currency] < $sum)  {

							$this->session->set_flashdata('error', lang('users error wallet'));
							redirect(site_url("account/money_transfer"));

						}

						elseif ($user[$currency] > $sum) {

							if ($protect == "none") {

								// update receiver wallet
								$this->users_model->update_wallet_transfer($receiver,
								array(
									$currency => $total_receiver,
									)
								);

							}

							// update sender wallet
							$this->users_model->update_wallet_transfer($user['username'],
							array(
								$currency => $total_sender,
								)
							);

							$label = uniqid("tms_");

							// add transaction for sender
							$transactions = $this->transactions_model->add_transaction(array(
								"type" 				=> "3",
								"sum"  				=> $sum,
								"fee"    			=> $fee,
								"amount" 			=> $amount,
								"currency"			=> $currency,
								"status" 			=> $status,
								"sender" 			=> $user['username'],
								"receiver" 			=> $user_receiver['username'],
								"time"          	=> date('Y-m-d H:i:s'),
								"user_comment"  	=> $note,
								"label" 	    => $label,
								"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
								"protect" 	    => $protect,
								)
							);
							
							$email_template = $this->template_model->get_email_template(25);
				
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
								$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[NAME]', '[SUM]', '[CUR]', '[RECEIVER]');

								$vals_1 = array($site_name, $link, $name_user, $amount, $symbol, $user_receiver['username']);

								//replace
								$str_1 = str_replace($placeholders, $vals_1, $rawstring);

								$this -> email -> from($this->settings->site_email, $this->settings->site_name);
								$this->email->to($user['email']);
								//$this -> email -> to($user['email']);
								$this -> email -> subject($email_template['title']);

								$this -> email -> message($str_1);

								$this->email->send();
							
							}
							
							$sms_template = $this->template_model->get_sms_template(15);
							
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
										$placeholders = array('[SUM]', '[CUR]', '[RECEIVER]');

										$vals_1 = array($amount, $symbol, $user_receiver['username']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}
							
									$mail_amount = number_format($amount, 2, '.', '');
											
											$email_template2 = $this->template_model->get_email_template(9);
											
											if($email_template2['status'] == "1") {
												
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
												$name_user2 = $user_receiver['first_name'] . ' ' . $user_receiver['last_name'];

												$rawstring = $email_template2['message'];

												// what will we replace
												$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[SUM]', '[CUR]', '[NAME]');

												$vals_1 = array($site_name, $site_link, $mail_amount, $symbol, $name_user2);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$this -> email -> from($this->settings->site_email, $this->settings->site_name);
												$this->email->to($user_receiver['email']);
												$this -> email -> subject($email_template2['title']);

												$this -> email -> message($str_1);

												$this->email->send();

											}
											
											$sms_template2 = $this->template_model->get_sms_template(20);
							
											if($sms_template2['status'] == "1") {
												
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

												$rawstring = $sms_template2['message'];

												// what will we replace
												$placeholders = array('[SUM]', '[CUR]');

												$vals_1 = array($mail_amount, $symbol);

												//replace
												$str_1 = str_replace($placeholders, $vals_1, $rawstring);

												$result = $this->sms->send_sms($user_receiver['phone'], $str_1);

											}

							// set content data
							$content_data = array(
								'user'              => $user,
								'user_receiver'     => $user_receiver,
								'percent'     		=> $percent,
							);

							// Send payeer email

							$this->session->set_flashdata('message', lang('users transfer success'));
							redirect(site_url("account/transactions"));

						}
						
					}
					
					
				}

		}
  
  /**************************************************************************************
    * PRIVATE VALIDATION CALLBACK FUNCTIONS
 **************************************************************************************/
	
	/**
     * Make sure username is available
     *
     * @param  string $username
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_username($username, $current)
    {
        if (trim($username) != trim($current) && $this->users_model->username_exists($username))
        {
            $this->form_validation->set_message('_check_username', sprintf(lang('users error username_exists'), $username));
						return $username;
        }
        else
        {
            return FALSE;
        }
    }
  
}