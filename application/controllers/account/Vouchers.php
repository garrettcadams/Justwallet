<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Vouchers extends Private_Controller {

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
        $this->load->model('vouchers_model');
      
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/vouchers'));
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
	* Vouchers
    */
	function index()
	{

		$user = $this->users_model->get_user($this->user['id']);
		$username = $user['username'];
		
		// get parameters
        $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
        $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
		
		// get filters
        $filters = array();
			
		if ($this->input->get('id'))
        {
            $id_xss = $this->security->xss_clean($this->input->get('id'));
			$id_string = str_replace(' ', '-', $id_xss);
			$id_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $id_string);
            $filters['id'] = $id_replace;
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

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }

			$vouchers = $this->vouchers_model->get_user_vouchers($limit, $offset, $filters, $sort, $dir, $username);	
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users vouchers menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$vouchers = $this->vouchers_model->get_user_vouchers($limit, $offset, $filters, $sort, $dir, $username);
		
		$user = $this->users_model->get_user($this->user['id']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $vouchers['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL,
            'vouchers'   => $vouchers['results'],
            'total'      => $vouchers['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/vouchers/index', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	/**
	*  New voucher page
    */
	function new_voucher()
	{

		// setup page header data
	    $this->set_title(sprintf(lang('users vouchers menu'), $this->settings->site_name));
			// reload the new user data and store in session
	    $user = $this->users_model->get_user($this->user['id']);
					
	    $data = $this->includes;

	    // set content data
	    $content_data = array(
			'user'    => $user,
	    );

    	// load views
    	$data['content'] = $this->load->view('account/vouchers/new_voucher', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	/**
	*  Activate page
    */
	function activate_code()
	{

		// setup page header data
	    $this->set_title(sprintf(lang('users vouchers menu'), $this->settings->site_name));
			// reload the new user data and store in session
	    $user = $this->users_model->get_user($this->user['id']);
					
	    $data = $this->includes;

	    // set content data
	    $content_data = array(
				'user'    => $user,
	    );

    	// load views
    	$data['content'] = $this->load->view('account/vouchers/activate_code', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
  
    /**
	* Start new voucher
    */
	function start_new_voucher()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', lang('users vouchers error_new'));
			redirect(site_url("account/vouchers/new_voucher"));

		} else {

			if ($user['fraud'] == 0) {

				if ($user['login_status'] == 2) {

					$amount = $this->input->post("amount", TRUE);
					$currency = $this->input->post("currency", TRUE);
						
					$percent = $this->settings->com_transfer/"100";
					$fee = $amount*$percent;
					$sum = $fee+$amount;
					$total = $user[$currency] - $sum;
					$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);
					
					// check user hold balance
					if ($total < $hold_balance) {
								
						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url("account/vouchers/new_voucher"));
								
					} else {
						
						// Check wallet
						if ($user[$currency] < $sum) {

							$this->session->set_flashdata('error', lang('users error wallet'));
							redirect(site_url("account/vouchers/new_voucher"));

						} else {

							$hash_string =
								$user['username'].':'.$user['salt'].':'.
								$sum.':'.
								date('Y-m-d H:i:s');

							$code = strtoupper(md5($hash_string));


							// update sender wallet
							$this->users_model->update_wallet_transfer($user['username'],
								array(
									$currency => $total,
								)
							);

							$label = uniqid("cvc_");

							// add transaction for sender
							$transactions = $this->transactions_model->add_transaction(array(
								"type" 				=> "2",
								"sum"  				=> $sum,
								"fee"    			=> $fee,
								"amount" 			=> $amount,
								"currency"			=> $currency,
								"status" 			=> "2",
								"sender" 			=> $user['username'],
								"receiver" 			=> "system",
								"time"          	=> date('Y-m-d H:i:s'),
								"user_comment"  	=> 'Create voucher '.$code.'',
								"label" 	    	=> $label,
								"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
								"protect" 	    	=> "none",
								)
							);

							// add voucher in base
							$voucher = $this->vouchers_model->add_voucher(array(
								"code" 					=> $code,
								"date_creature" 		=> date('Y-m-d H:i:s'),
								"creator"    			=> $user['username'],
								"amount" 				=> $amount,
								"currency"				=> $currency,
								"date_activation" 		=> "0000-00-00 00:00:00",
								"activator" 			=> "none",
								"status" 				=> "1"
								)
							);

							$this->session->set_flashdata('message', lang('users vouchers success_new'));
							redirect(site_url('account/vouchers'));

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
	
	/**
	* Start activate code 
    */
	function start_activate_code()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('code', lang('users vouchers code'), 'required|trim|max_length[50]|min_length[10]');
		
		if ($this->form_validation->run() == FALSE)
		{

			$this->session->set_flashdata('error', lang('users vouchers error'));
			redirect(site_url("account/vouchers/activate_code"));

		} else {
			
			$code = $this->input->post("code", TRUE);
				
			$check_code = $this->vouchers_model->validate_code($code);
			
			// if empty results, return to list
			if ( ! $check_code or $check_code['status'] == 3)
			{
					
				$this->session->set_flashdata('error', lang('users vouchers error'));
				redirect(site_url("account/vouchers/activate_code"));
					
			} else {
				
				$currency_code = $check_code['currency'];
				
				$label = uniqid("anv_");
				
				$transactions = $this->transactions_model->add_transaction(array(
					"type" 					=> "1",
					"sum"  					=> $check_code['amount'],
					"fee"    				=> "0.00",
					"amount" 				=> $check_code['amount'],
					"currency"				=> $currency_code,
					"status" 				=> "2",
					"sender" 				=> "system",
					"receiver" 				=> $user['username'],
					"time"          		=> date('Y-m-d H:i:s'),
					"user_comment"  		=> 'Activate voucher '.$check_code['code'].'',
					"admin_comment" 		=> "none",
					"label" 	    		=> $label,
			        "ip_address" 	    	=> $_SERVER["REMOTE_ADDR"],
			        "protect" 	    		=> "none",
					)
				);
				
				$total = $user[$currency_code]+$check_code['amount'];
			
				// update wallet
				$this->users_model->update_wallet_transfer($user['username'],
					array(
						$currency_code => $total,
					)
				);
					
				// update status voucher
				$this->vouchers_model->update_voucher($code,
					array(
						"status" 			=> "2",
						"date_activation" 	=> date('Y-m-d H:i:s'),
						"activator" 		=> $user['username'],
					)
				);
					
				$this->session->set_flashdata('message', lang('users vouchers success'));
				redirect(site_url('account/transactions'));
				
			}
			
		}
		
	}
	
	
}