<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Settings extends Private_Controller {

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
		$this->load->model('events_model');
		$this->load->model('verification_model');
		$this->load->model('transactions_model');
		$this->load->library('googleauthenticator.php');
			
		// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/settings/logs'));
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "id");
        define('DEFAULT_DIR', "desc");

        // use the url in session (if available) to return to the previous filter/sorted/paginated list
        if ($this->session->userdata(REFERRER))
        {
            $this->_redirect_url = $this->session->userdata(REFERRER);
        }
        else
        {
            $this->_redirect_url = THIS_URL;
        }
    }
  
    /**
	* Main settings
    */
	function index()
	{

    	$user = $this->users_model->get_user($this->user['id']);
		
		// validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('first_name', lang('users settings first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('users settings last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('users settings email'), 'required|trim|max_length[128]|valid_email|callback__check_email');
        $this->form_validation->set_rules('language', lang('users settings language'), 'required|trim');
        $this->form_validation->set_rules('password_repeat', lang('users settings re_password'), 'min_length[5]');
        $this->form_validation->set_rules('password', lang('users settings password'), 'min_length[5]|matches[password_repeat]');

        if ($this->form_validation->run() == TRUE)
        {
			//security XSS
			$securety_post = $this->security->xss_clean($this->input->post());
            // save the changes
            $saved = $this->users_model->edit_profile($this->security->xss_clean($this->input->post()), $this->user['id']);

            if ($saved)
            {

				// Register event
							
				$event = $this->events_model->register_event(array(
					"type" 				=> "2",
					"user"  			=> $user['username'],
					"ip"    			=> $_SERVER['REMOTE_ADDR'],
					"date" 			  	=> date('Y-m-d H:i:s'),
					"code"			  	=> uniqid("evn_"),
					)
				);
							
                // reload the new user data and store in session
                $this->user = $this->users_model->get_user($this->user['id']);
                unset($this->user['password']);
                unset($this->user['salt']);

                $this->session->set_userdata('logged_in', $this->user);
                $this->session->language = $this->user['language'];
                $this->lang->load('users', $this->user['language']);
                $this->session->set_flashdata('message', lang('users msg edit_profile_success'));

            }
            else
            {

                $this->session->set_flashdata('error', lang('users error edit_profile_failed'));

            }

            // reload page and display message
            redirect('account/settings');
        }
		
        // setup page header data
        $this->set_title(sprintf(lang('users settings title'), $this->settings->site_name));
		// reload the new user data and store in session
       

        $data = $this->includes;

        /// set content data
        $content_data = array(
            'cancel_url'        => base_url(),
            'user'              => $user,
            'password_required' => FALSE
        );

        // load views
        $data['content'] = $this->load->view('account/settings/settings', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	

	/**
	* Security settings
    */
	function security()
	{

		$user = $this->users_model->get_user($this->user['id']);
		
		$authenticator = new Googleauthenticator();
		$secret = $authenticator->createSecret();

		$website = "JDT"; //Your Website
		$title = "JastWallet";
		$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($title, $secret, $website);
		
		// setup page header data
        $this->set_title(sprintf(lang('users security title'), $this->settings->site_name));
		// reload the new user data and store in session
       

        $data = $this->includes;

        /// set content data
        $content_data = array(
			'secret'              => $secret,
			'qrCodeUrl'              => $qrCodeUrl,
            'cancel_url'        => base_url(),
            'user'              => $user,
            'password_required' => FALSE
        );

    	// load views
    	$data['content'] = $this->load->view('account/settings/security', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	/**
	* Update 2fa settings
    */
	function update_2fa()
	{

		$authenticator = new Googleauthenticator();
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('code', 'OTP code', 'required|trim|numeric');
		$this->form_validation->set_rules('secret', 'Secret', 'required|trim');
		
		if ($this->form_validation->run() == TRUE)
		{
			
			if ($user['2fa_login'] == NULL) {
				
				$secret = $this->input->post("secret", TRUE);
				$otp = $this->input->post("code", TRUE);
				
				$tolerance = 0;
				
				$checkResult = $authenticator->verifyCode($secret, $otp, $tolerance);
				
				if ($checkResult) {
					
					// update user
					$this->users_model->update_setting_user($user['id'],
					array(
						"2fa_login"   => $secret,
						)
					);
					
					$this->session->set_flashdata('message', lang('users security update_success'));
					redirect(site_url("account/settings/security"));
					
				} else {
					
					$this->session->set_flashdata('error', lang('users security fail_2fa_token2'));
					redirect(site_url("account/settings/security"));
					
				}
				
			} else {
				
				$this->session->set_flashdata('error', lang('users security fail_2fa_token'));
				redirect(site_url("account/settings/security"));
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users security fail_2fa_form'));
			redirect(site_url("account/settings/security"));
			
		}
		
	}
	
	/**
	* Update securety settings
    */
	function update_security()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('method', lang('users security title'), 'required|in_list[1,2,3,4]');
		
		$method = $this->input->post('method', TRUE);
		
		if ($this->form_validation->run() == TRUE)
    	{
			
			// 2fa
			if ($method == 2) {
				
				if ($user['2fa_login'] == NULL) {
					
					// null user return
					$this->session->set_flashdata('error', lang('users security update_2fa'));
					redirect(site_url("account/settings/security"));
					
				} else {
					
					// save method
					// update user
					$this->users_model->update_setting_user($user['id'],
					array(
						"method_login"   => $method,
						)
					);
					
					$this->session->set_flashdata('message', lang('users security update_success'));
					redirect(site_url("account/settings/security"));
					
				}
				
			} elseif ($method == 3) { // sms
				
				if ($user['phone'] == NULL) {
					
					// null return
					$this->session->set_flashdata('error', lang('users security update_phone'));
					redirect(site_url("account/settings/security"));
					
				} else {
					
					// save method 
					// update user
					$this->users_model->update_setting_user($user['id'],
					array(
						"method_login"   => $method,
						)
					);
					
					$this->session->set_flashdata('message', lang('users security update_success'));
					redirect(site_url("account/settings/security"));
					
				}
				
			} else { // other methods
				
				// update user
				$this->users_model->update_setting_user($user['id'],
				array(
					"method_login"   => $method,
					)
				);
				
				$this->session->set_flashdata('message', lang('users security update_success'));
				redirect(site_url("account/settings/security"));
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users security update_fail'));
			redirect(site_url("account/settings/security"));
			
		}
		
	}
	
	/**
	* Billing
    */
	function billing()
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
        
        // setup page header data
        $this->set_title(sprintf(lang('users settings billing'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
			'user'              	=> $user,
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
        $data['content'] = $this->load->view('account/settings/billing', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	/**
	* Uodate billing settings - PayPal
    */
	function update_paypal()
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(1);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('paypal', lang('users settings paypal'), 'required|trim|min_length[2]|max_length[32]');
		
		$paypal = $this->security->xss_clean($this->input->post("paypal", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"paypal"   => $paypal,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Uodate billing settings - CC
    */
	function update_credit_card()
	{

		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(2);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('card', lang('users settings card'), 'required|trim|numeric|min_length[2]|max_length[32]');
		
		$card = $this->security->xss_clean($this->input->post("card", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"card"   => $card,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Uodate billing settings - Bitcoin
    */
	function update_bitcoin()
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(3);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('bitcoin', lang('users settings bitcoin'), 'required|trim|min_length[2]|max_length[50]');
		
		$bitcoin = $this->security->xss_clean($this->input->post("bitcoin", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"bitcoin"   => $bitcoin,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Uodate billing settings - Skrill
    */
	function update_skrill()
	{

		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(5);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('skrill', lang('users settings skrill'), 'required|trim|min_length[2]|max_length[32]');
		
		$skrill = $this->security->xss_clean($this->input->post("skrill", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"skrill"   => $skrill,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Uodate billing settings - Payza
    */
	function update_payza()
	{

		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(6);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('payza', lang('users settings payza'), 'required|trim|min_length[2]|max_length[32]');
		
		$payza = $this->security->xss_clean($this->input->post("payza", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"payza"   => $payza,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Uodate billing settings - ADV Cash
    */
	function update_advcash()
	{

		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(7);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('advcash', lang('users settings advcash'), 'required|trim|min_length[2]|max_length[32]');
		
		$advcash = $this->security->xss_clean($this->input->post("advcash", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"advcash"   => $advcash,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Update billing settings - Perfect Money
    */
	function update_perfect_m()
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(8);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('perfect_m', lang('users settings perfect_m'), 'required|trim|min_length[2]|max_length[32]');
		
		$perfect_m = $this->security->xss_clean($this->input->post("perfect_m", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"perfect_m"   => $perfect_m,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Update billing settings - SWIFT
    */
	function update_swift()
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$method = $this->settings_model->get_win_method(4);
		
		// Check enabled method
		if ($method['start_verify'] == "1" && $user['verify_status'] == 0) {

			$enabled = TRUE;

		} elseif ($method['standart_verify'] == "1" && $user['verify_status'] == 1) {

			$enabled = TRUE;

		} elseif ($method['expanded_verify'] == "1" && $user['verify_status'] == 2) {

			$enabled = TRUE;

		} else {

			$enabled = FALSE;

		}
		
		$this->form_validation->set_rules('swift', lang('users settings swift'), 'required|trim|min_length[2]');
		
		$swift = $this->security->xss_clean($this->input->post("swift", TRUE));
		
		if ($this->form_validation->run() == TRUE && $method['status'] == 1)
    	{
			if($enabled == TRUE) {

				// update user
				$this->users_model->update_setting_user($user['id'],
					array(
						"swift"   => $swift,
					)
				);

			} else {

				$this->session->set_flashdata('error', lang('users settings no_verify'));
				redirect(site_url("account/settings/billing"));

			}
			
			$this->session->set_flashdata('message', lang('users settings billing_success'));
			redirect(site_url("account/settings/billing"));

		} else {

			$this->session->set_flashdata('error', lang('users settings billing_fale'));
			redirect(site_url("account/settings/billing"));

		}
	}
	
	/**
	* Verification settings
    */
	function verification()
	{
		 $user = $this->users_model->get_user($this->user['id']);

		 $request = $this->verification_model->get_verification($user['username']);
		
		 if ($request == NULL) {
			 
			 $check_request = 0;
			 
		 } else {
			 
			 $check_request = 1;
			 
		 }

		 // setup page header data
		 $this->set_title(sprintf(lang('users settings verify'), $this->settings->site_name));

		 $data = $this->includes;

		 // set content data
		 $content_data = array(	
			"user"   		  => $user,
			"check_request"   => $check_request,
		 );

		 // load views
		 $data['content'] = $this->load->view('account/settings/verification', $content_data, TRUE);
		 $this->load->view($this->template, $data);
	}
	
	/**
	* Update stadart verification settings
    */
	function standart_verification()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('company', lang('users settings company'), 'max_length[150]');
		$this->form_validation->set_rules('country', lang('users settings country'), 'required|max_length[100]');
		$this->form_validation->set_rules('zip', lang('users settings zip'), 'required|max_length[50]|min_length[2]');
		$this->form_validation->set_rules('city', lang('users settings city'), 'required|max_length[100]|min_length[2]');
		$this->form_validation->set_rules('address_1', lang('users settings address_1'), 'required|max_length[300]|min_length[2]');
		$this->form_validation->set_rules('address_1', lang('users settings address_1'), 'max_length[300]|min_length[2]');
		$this->form_validation->set_rules('phone', lang('users settings city'), 'required|numeric|max_length[15]|min_length[8]|callback__check_phone');
		
		$post_data = $this->security->xss_clean($this->input->post());
		
		if ($this->form_validation->run() == TRUE && $user['verify_status'] == 0)
    	{
			
			$saved = $this->users_model->standart_verification($post_data, $this->user['id']);
			
			$this->users_model->update_setting_user($user['id'],
				array(
					"verify_status"   => "1",
				)
			);
			
			$this->session->set_flashdata('message', lang('users settings verify_success'));
			redirect(site_url("account/settings/verification"));
			
		} else {
			
			$this->session->set_flashdata('error', lang('users settings verify_fail'));
			redirect(site_url("account/settings/verification"));
			
		}
		
	}
	
	/**
	* Update extended verification settings
    */
	function extended_verification()
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		if ($user['verify_status'] == 1) {
			
			$config['upload_path']          = ''.$this->settings->full_upload.'/'.$this->settings->upload_path.'/';
			$config['upload_path']          = ''.$_SERVER['DOCUMENT_ROOT'].'/upload/verify';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 40000; // 5mb
			$config['encrypt_name']         = TRUE;
			$config['remove_spaces']        = TRUE;
			
			$this->load->library('upload', $config);
			
			$code = uniqid("doc_");

			if (! $this->upload->do_upload('id_card')) {
				
				$this->session->set_flashdata('error', lang('users settings id_card_fail'));
				redirect(site_url("account/settings/verification"));

			} else {
				
				$document = $this->verification_model->add_document(array(
					"code"       => $code,
					"date"       => date('Y-m-d H:i:s'),
					"id_card"  	 => $this->upload->data('file_name'),
					"status"     => "0",
					"user"       => $user['username'],
					)
				);

			} 
			
			if (! $this->upload->do_upload('id_address')) {
				
				$this->session->set_flashdata('error', lang('users settings id_address_fail'));
				redirect(site_url("account/settings/verification"));
				
			} else {
				
				// update verification address
				$this->verification_model->update_verification($code,
					array(
						"id_address"   => $this->upload->data('file_name')
					)
				);
				
			}
			
			$email_template = $this->template_model->get_email_template(18);
			
			if($email_template['status'] == "1") {
			
				// variables to replace
				$site_name = $this->settings->site_name;
				$link = site_url('account/settings/verification');
				$name_user = $user['first_name'] . ' ' . $user['last_name'];

				$rawstring = $email_template['message'];

				// what will we replace
				$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]');

				$vals_1 = array($site_name, $link, $name_user);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$this -> email -> from($this->settings->site_email, $this->settings->site_name);
				$this->email->to($user['email']);
				//$this -> email -> to($user['email']);
				$this -> email -> subject($email_template['title']);

				$this -> email -> message($str_1);

				$this->email->send();

			}
			
			$this->session->set_flashdata('message', lang('users settings id_doc_success'));
			redirect(site_url("account/settings/verification"));
			
		} else {
			
			$this->session->set_flashdata('error', lang('users settings verify_fail'));
			edirect(site_url("account/settings/verification"));
			
		}

	}
	
	/**
    * Activity Log
    */
    function logs()
    {

		$user = $this->users_model->get_user($this->user['id']);
		// get parameters
	    $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
	    $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
	    $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
	    $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
			
		// get filters
	    $filters = array();

	    if ($this->input->get('id', TRUE))
	    {
	        $id_xss = $this->security->xss_clean($this->input->get('id'));
			$id_replace = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
	        $filters['id'] = $id_replace;
	    }

	    if ($this->input->get('user', TRUE))
	    {
	        $user_xss = $this->security->xss_clean($this->input->get('user'));
			$user_replace = htmlentities($user_xss, ENT_QUOTES, "UTF-8");
	        $filters['user'] = $user_replace;
	    }

	    if ($this->input->get('date', TRUE))
	    {
	        $date_xss = $this->security->xss_clean($this->input->get('date'));
			$date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
	        $filters['created'] = date('Y-m-d', strtotime(str_replace('-', '/', $date_string)));
	    }
				
		if ($this->input->get('code', TRUE))
	    {
	        $code_xss = $this->security->xss_clean($this->input->get('code'));
			$code_string = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
	        $filters['code'] =$code_string;
	    }
				
		if ($this->input->get('type', TRUE))
	    {
	        $event_xss = $this->security->xss_clean($this->input->get('event'));
			$event_replace = htmlentities($event_xss, ENT_QUOTES, "UTF-8");
	        $filters['event'] = $event_replace;
	    }
				
		if ($this->input->get('ip', TRUE))
	    {
	        $ip_xss = $this->security->xss_clean($this->input->get('ip'));
			$ip_replace = htmlentities($ip_xss, ENT_QUOTES, "UTF-8");
	        $filters['ip'] = $ip_replace;
	    }
			
		// build filter string
	    $filter = "";
	    foreach ($filters as $key => $value)
	    {
	        $filter .= "&{$key}={$value}";
	    }
			
		// are filters being submitted?
	    if ($this->input->post())
	    {
	        if ($this->input->post('clear'))
	        {
	            // reset button clicked
	             redirect(THIS_URL);
	        }
	        else
	        {
	            // apply the filter(s)
	            $filter = "";

	            if ($this->input->post('id'))
	            {
	                $filter .= "&id=" . $this->input->post('id', TRUE);
	            }

	            if ($this->input->post('user'))
	            {
	                $filter .= "&user=" . $this->input->post('user', TRUE);
	            }

	            if ($this->input->post('date'))
	            {
	                $filter .= "&date=" . $this->input->post('date', TRUE);
	            }
								
				if ($this->input->post('code'))
	            {
	                $filter .= "&code=" . $this->input->post('code', TRUE);
	            }
								
				if ($this->input->post('event'))
	            {
	                $filter .= "&type=" . $this->input->post('event', TRUE);
	            }
								
				if ($this->input->post('ip'))
	            {
	                $filter .= "&ip=" . $this->input->post('ip', TRUE);
	            }

	            // redirect using new filter(s)
	            redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
	        }
						
			// get list
			$logs = $this->events_model->get_list_user_events($limit, $offset, $filters, $sort, $dir, $user['username']);
						
	    }
			
		// save the current url to session for returning
	    $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
				
	    // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('users settings logs') );
			
	    $data = $this->includes;
				
		// get list
		$logs = $this->events_model->get_list_user_events($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $logs['total'],
			'per_page'   => $limit
		));
				
		// set content data
	    $content_data = array(
			'user'   => $user,
	        'this_url'   => THIS_URL,
	        'logs'       => $logs['results'],
	        'total'      => $logs['total'],
	        'filters'    => $filters,
	        'filter'     => $filter,
	        'pagination' => $this->pagination->create_links(),
	        'limit'      => $limit,
	        'offset'     => $offset,
	        'sort'       => $sort,
	        'dir'        => $dir
	    );

	    // load views
	    $data['content'] = $this->load->view('account/settings/logs', $content_data, TRUE);
	    $this->load->view($this->template, $data);

    }
	
	/**
     * Make sure email is available
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email($email)
    {
        if (trim($email) != $this->user['email'] && $this->users_model->email_exists($email))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_exists'), $email));
            return FALSE;
        }
        else
        {
            return $email;
        }
    }

    /**
     * Make sure phone is available
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_phone($phone)
    {
        if (trim($phone) != $this->user['phone'] && $this->users_model->phone_exists($phone))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_exists'), $phone));
            return FALSE;
        }
        else
        {
            return $phone;
        }
    }
  
}