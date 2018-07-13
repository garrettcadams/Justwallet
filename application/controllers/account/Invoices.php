<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends Private_Controller {

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
			  $this->load->model('invoices_model');
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/invoices'));
				define('THIS_URL_2', base_url('account/invoices/inbox'));
				define('THIS_URL_3', base_url('account/invoices/sent'));
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
	 * Default
     */

	function index()
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
			$id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
			$filters['id'] = $id_string;
    }
		if ($this->input->get('date'))
    {
      $date_xss = $this->security->xss_clean($this->input->get('date'));
			$date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
			$filters['date'] = $date_string;
    }
		
		if ($this->input->get('sender'))
    {
			$sender_xss = $this->security->xss_clean($this->input->get('sender'));
			$sender_string = htmlentities($sender_xss, ENT_QUOTES, "UTF-8");
			$filters['sender'] = $sender_string;
    }
		
		if ($this->input->get('receiver'))
    {
      $receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
			$receiver_string = htmlentities($receiver_xss, ENT_QUOTES, "UTF-8");
			$filters['receiver'] = $receiver_string;
    }
		
		if ($this->input->get('amount'))
    {
      $amount_xss = $this->security->xss_clean($this->input->get('amount'));
			$amount_string = htmlentities($amount_xss, ENT_QUOTES, "UTF-8");
			$filters['amount'] = $amount_string;
    }
		
		if ($this->input->get('name'))
    {
      $name_xss = $this->security->xss_clean($this->input->get('name'));
			$name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
			$filters['name'] = $name_string;
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
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
								if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_user_invoices($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_user_invoices($limit, $offset, $filters, $sort, $dir, $user['username']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL,
            'history'    => $history['results'],
            'total'      => $history['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/invoices/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	function inbox()
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
			$id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
			$filters['id'] = $id_string;
    }
		if ($this->input->get('date'))
    {
      $date_xss = $this->security->xss_clean($this->input->get('date'));
			$date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
			$filters['date'] = $date_string;
    }
		
		if ($this->input->get('sender'))
    {
			$sender_xss = $this->security->xss_clean($this->input->get('sender'));
			$sender_string = htmlentities($sender_xss, ENT_QUOTES, "UTF-8");
			$filters['sender'] = $sender_string;
    }
		
		if ($this->input->get('receiver'))
    {
      $receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
			$receiver_string = htmlentities($receiver_xss, ENT_QUOTES, "UTF-8");
			$filters['receiver'] = $receiver_string;
    }
		
		if ($this->input->get('amount'))
    {
      $amount_xss = $this->security->xss_clean($this->input->get('amount'));
			$amount_string = htmlentities($amount_xss, ENT_QUOTES, "UTF-8");
			$filters['amount'] = $amount_string;
    }
		
		if ($this->input->get('name'))
    {
      $name_xss = $this->security->xss_clean($this->input->get('name'));
			$name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
			$filters['name'] = $name_string;
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
                redirect(THIS_URL_2);
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
								if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_user_inbox_invoices($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_user_inbox_invoices($limit, $offset, $filters, $sort, $dir, $user['username']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL_2,
            'history'    => $history['results'],
            'total'      => $history['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/invoices/inbox', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	function sent()
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
			$id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
			$filters['id'] = $id_string;
    }
		if ($this->input->get('date'))
    {
      $date_xss = $this->security->xss_clean($this->input->get('date'));
			$date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
			$filters['date'] = $date_string;
    }
		
		if ($this->input->get('sender'))
    {
			$sender_xss = $this->security->xss_clean($this->input->get('sender'));
			$sender_string = htmlentities($sender_xss, ENT_QUOTES, "UTF-8");
			$filters['sender'] = $sender_string;
    }
		
		if ($this->input->get('receiver'))
    {
      $receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
			$receiver_string = htmlentities($receiver_xss, ENT_QUOTES, "UTF-8");
			$filters['receiver'] = $receiver_string;
    }
		
		if ($this->input->get('amount'))
    {
      $amount_xss = $this->security->xss_clean($this->input->get('amount'));
			$amount_string = htmlentities($amount_xss, ENT_QUOTES, "UTF-8");
			$filters['amount'] = $amount_string;
    }
		
		if ($this->input->get('name'))
    {
      $name_xss = $this->security->xss_clean($this->input->get('name'));
			$name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
			$filters['name'] = $name_string;
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
                redirect(THIS_URL_3);
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
								if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_user_sent_invoices($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_user_sent_invoices($limit, $offset, $filters, $sort, $dir, $user['username']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL_3,
            'history'    => $history['results'],
            'total'      => $history['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/invoices/sent', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
  
  /**
    * Detail invoice
    */
	function detail($id = NULL)
    {
		$user = $this->users_model->get_user($this->user['id']);
			
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $invoice = $this->invoices_model->get_detail_invoice($id, $user['username']);

        // if empty results, return to list
        if ( ! $invoice)
        {
            redirect($this->_redirect_url);
        }
    
        $currency = $invoice['currency'];

        $sender = $this->users_model->get_username($invoice['sender']);
    
        // check currency
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
			
        // setup page header data
        $this->set_title( lang('users invoices menu') );

        $data = $this->includes;

        // set content data
        $content_data = array(
          'this_url'   		=> THIS_URL,
          'user'              => $user,
          'cancel_url'        => $this->_redirect_url,
          'invoice'      => $invoice,
          'invoice_id'   => $id,
          'symbol'   => $symbol,
          'sender'   => $sender
        );

        // load views
        $data['content'] = $this->load->view('account/invoices/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
  function pay_invoice($id = NULL)
  {
    
    $user = $this->users_model->get_user($this->user['id']);
			
    // make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
      redirect($this->_redirect_url);
    }
    
    // get the data
    $invoice = $this->invoices_model->get_detail_invoice($id, $user['username']);
    
    if ($invoice['receiver'] == $user['username']) {
      
      if ($invoice['status'] == 1) {
        
        $currency_payment = $invoice['currency'];

        //check ballance user wallet
        if ($user[$currency_payment] >= $invoice['total']) {
          
          $label = uniqid("ivp_");
          
          $sender = $this->users_model->get_username($invoice['sender']);
					
					$wallet_total = $user[$currency_payment] - $invoice['total'];
					
					$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency_payment);
					
					// check user hold balance
					if ($wallet_total < $hold_balance) {
						
						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url("account/invoices"));
						
					} else {
						
						// update wallet receiver
						$this->users_model->update_wallet_transfer($user['username'],
							array(
								$currency_payment => $wallet_total,
							)
						);
						// update wallet sender
						$wallet_total2 = $sender[$currency_payment] + $invoice['amount'];
						$this->users_model->update_wallet_transfer($sender['username'],
							array(
								$currency_payment => $wallet_total2,
							)
						);

						// add new transaction
						$transactions = $this->transactions_model->add_transaction(array(
							"type" 				=> "3",
							"sum"  				=> $invoice['total'],
							"fee"    			=> $invoice['fee'],
							"amount" 			=> $invoice['amount'],
							"currency"		=> $currency_payment,
							"status" 			=> "2",
							"sender" 			=> $user['username'],
							"receiver" 		=> $sender['username'],
							"time"          	=> date('Y-m-d H:i:s'),
							"label" 	    => $label,
							"admin_comment" 	    => "none",
							"user_comment" 	    => 'Payment invoice ID '.$invoice['id'].'',
							"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
							"protect" 	    => "none",
							)
						);

						// update invoice
						$this->invoices_model->update_invoice($invoice['id'],
							array(
								"status"  => "2"
							)
						);

						$this->session->set_flashdata('message', lang('users invoices success'));
						redirect(site_url("account/transactions"));
						
					}

        } else {

          // no money to pay
          $this->session->set_flashdata('error', lang('users invoices error_1'));
					redirect(site_url("account/invoices"));

        }
        
      } else {
        
        // status not pending
        $this->session->set_flashdata('error', lang('users invoices error_2'));
				redirect(site_url("account/invoices"));
        
      }
      
    } else {
      
      // user not permission for payment
      $this->session->set_flashdata('error', lang('users invoices error_2'));
			redirect(site_url("account/invoices"));
      
    }
    
  }
  
  function cancel_invoice($id = NULL)
  {
    
    $user = $this->users_model->get_user($this->user['id']);
			
    // make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
      redirect($this->_redirect_url);
    }
    
    // get the data
    $invoice = $this->invoices_model->get_detail_invoice($id, $user['username']);
    
    if ($invoice['receiver'] == $user['username']) {
      
      if ($invoice['status'] == 1) {
        
        // update invoice
        $this->invoices_model->update_invoice($invoice['id'],
          array(
            "status"  => "3"
          )
        );
				
				$email_template = $this->template_model->get_email_template(29);
			
			$user_mail = $this->users_model->get_username($invoice['sender']);
				
							if($email_template['status'] == "1") {
								
								// variables to replace
								$site_name = $this->settings->site_name;
								$link = site_url('account/invoices');
								$name_user = $user_mail['first_name'] . ' ' . $user_mail['last_name'];

								$rawstring = $email_template['message'];

								// what will we replace
								$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[NAME]', '[ID_INVOICE]');

								$vals_1 = array($site_name, $link, $name_user, $invoice['id']);

								//replace
								$str_1 = str_replace($placeholders, $vals_1, $rawstring);

								$this -> email -> from($this->settings->site_email, $this->settings->site_name);
								$this->email->to($user_mail['email']);
								//$this -> email -> to($user['email']);
								$this -> email -> subject($email_template['title']);

								$this -> email -> message($str_1);

								$this->email->send();
							
							}
				
				$sms_template = $this->template_model->get_sms_template(19);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[ID_INVOICE]');

										$vals_1 = array($invoice['id']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user_mail['phone'], $str_1);
										
									}

          
        $this->session->set_flashdata('message', lang('users invoices success_2'));
			  redirect(site_url("account/invoices"));
        
      } else {
        
        // user not permission for payment
        $this->session->set_flashdata('error', lang('users invoices error_2'));
        redirect(site_url("account/invoices"));
      }
      
    } else {
      
      // user not permission for payment
      $this->session->set_flashdata('error', lang('users invoices error_2'));
			redirect(site_url("account/invoices"));
      
    }
    
  }
  
  function new_invoice()
  {
    
    $user = $this->users_model->get_user($this->user['id']);
		
    // setup page header data
    $this->set_title(sprintf(lang('users invoices menu'), $this->settings->site_name));

    $data = $this->includes;
		
    // set content data
    $content_data = array(
			'user'   => $user,
    );

    // load views
    $data['content'] = $this->load->view('account/invoices/new', $content_data, TRUE);
		$this->load->view($this->template, $data);
    
  }
  
  function start_invoice()
  {
    $user = $this->users_model->get_user($this->user['id']);
    
    $this->form_validation->set_rules('name', lang('users invoices name'), 'required|trim|max_length[200]|min_length[3]');
    $this->form_validation->set_rules('info', lang('users invoices description'), 'required|max_length[2000]|min_length[3]');
    $this->form_validation->set_rules('receiver', lang('users transfer user_mail'), 'required|trim|callback__check_username[]');
    $this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
    
    if ($this->form_validation->run() == FALSE)
		{
      
			// FALSE check form
      $this->session->set_flashdata('error', lang('users invoices error_3'));
      redirect(site_url("account/invoices/new_invoice"));
      
		} else {
			
			
      
      $amount = $this->input->post("amount", TRUE);
			$currency = $this->input->post("currency", TRUE);
			$receiver = $this->input->post("receiver", TRUE);
      $name = $this->input->post("name", TRUE);
			$info = $this->input->post("info", TRUE);
			
			// Calculation of the commission and total sum
			$percent = $this->settings->com_invoice/"100";
			$fee = $amount * $percent;
			$sum = $fee + $amount;
      
      $label = uniqid("inv_");
			
			if ($user['username'] == $receiver) {
				
				$this->session->set_flashdata('error', lang('users invoices error_3'));
      	redirect(site_url("account/invoices/new_invoice"));
				
			}
      
      // add new transaction
			$invoice = $this->invoices_model->add_invoice(array(
				"code" 				=> $label,
        "date" 				=> date('Y-m-d H:i:s'),
        "name" 				=> $name,
				"info" 				=> $info,
				"amount" 			=> $amount,
				"fee" 				=> $fee,
				"total" 			=> $sum,
				"currency" 		=> $currency,
				"sender" 			=> $user['username'],
				"receiver" 		=> $receiver,
				"status" 			=> "1",
				)
			);
			
			$email_template = $this->template_model->get_email_template(28);
			
			$user_mail = $this->users_model->get_username($receiver);
				
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
								$link = site_url('account/invoices');
								$name_user = $user_mail['first_name'] . ' ' . $user_mail['last_name'];

								$rawstring = $email_template['message'];

								// what will we replace
								$placeholders = array('[SITE_NAME]', '[SITE_LINK]', '[NAME]', '[SUM]', '[CUR]');

								$vals_1 = array($site_name, $link, $name_user, $amount, $symbol);

								//replace
								$str_1 = str_replace($placeholders, $vals_1, $rawstring);

								$this -> email -> from($this->settings->site_email, $this->settings->site_name);
								$this->email->to($user_mail['email']);
								//$this -> email -> to($user['email']);
								$this -> email -> subject($email_template['title']);

								$this -> email -> message($str_1);

								$this->email->send();
							
							}
			
			$sms_template = $this->template_model->get_sms_template(18);
							
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

										$vals_1 = array($amount, $symbol);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user_mail['phone'], $str_1);
										
									}

			
			$this->session->set_flashdata('message', lang('users invoices success_3'));
			redirect(site_url("account/invoices"));
      
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