<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shops extends Private_Controller {

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
			  $this->load->model('merchants_model');
				$this->load->model('cart_model');
				$this->load->model('orders_model');
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/shops'));
				define('THIS_URL_2', base_url('account/shops/merchants'));
				define('THIS_URL_3', base_url('account/shops/search'));
				define('THIS_URL_4', base_url('account/shops/items'));
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
		
		$all_shops = $this->merchants_model->get_all_shops();
		
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
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_shops($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_shops($limit, $offset, $filters, $sort, $dir);
					
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
			'all_shops'   => $all_shops,
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
        $data['content'] = $this->load->view('account/shops/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	     /**
	 * Default
     */

	function merchants($id = NULL)
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$category = $this->merchants_model->get_category($id);
		
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
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$shops = $this->merchants_model->get_shops_category($limit, $offset, $filters, $sort, $dir, $id);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$shops = $this->merchants_model->get_shops_category($limit, $offset, $filters, $sort, $dir, $id);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $shops['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
			'category'   => $category,
            'this_url'   => THIS_URL_2,
            'shops'    => $shops['results'],
            'total'      => $shops['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/shops/merchants', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	function payment($id = NULL)
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		// get the data
    $merchant = $this->merchants_model->get_payment_merchant($id);

    // if empty results, return to list
    if ( ! $merchant)
    {
    	redirect(site_url("account/shops"));
    }
		
		// setup page header data
    $this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));
		// reload the new user data and store in session

    $data = $this->includes;
		
		 // set content data
     $content_data = array(
     	'user'              => $user,
      'merchant'      => $merchant,
     );

     // load views
     $data['content'] = $this->load->view('account/shops/payment', $content_data, TRUE);
     $this->load->view($this->template, $data);
		
		
	}
	
	function category($id = NULL)
	{
		// get parameters
    $offset = "0";
    $sort   = "id";
    $dir    = "desc";
		
		$user = $this->users_model->get_user($this->user['id']);
		
		// get the data
    $merchant = $this->merchants_model->get_payment_merchant($id);

    // if empty results, return to list
    if ( ! $merchant)
    {
    	redirect(site_url("account/shops"));
    }
		
		$categories = $this->merchants_model->get_select_merchant_categories_all($offset, $filters, $sort, $dir, $id, $user['username']);
		
		// setup page header data
    $this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));
		// reload the new user data and store in session

    $data = $this->includes;
		
		 // set content data
     $content_data = array(
     	'user'              => $user,
      'merchant'      => $merchant,
			'categories'    => $categories['results'],
			'total'      => $categories['total'],
     );

     // load views
     $data['content'] = $this->load->view('account/shops/category', $content_data, TRUE);
     $this->load->view($this->template, $data);
		
		
	}
	
	function items($id = NULL)
	{
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$category = $this->merchants_model->get_shop_category($id);
		
		$coreect_url = base_url('account/shops/items/'.$id.'');
		
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
                redirect($coreect_url);
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect($coreect_url . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$items = $this->merchants_model->get_shops_items($limit, $offset, $filters, $sort, $dir, $id);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$items = $this->merchants_model->get_shops_items($limit, $offset, $filters, $sort, $dir, $id);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => $coreect_url . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $items['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
			'category'   => $category,
            'this_url'   => $coreect_url,
            'items'    => $items['results'],
            'total'      => $items['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/shops/items', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	function detail_item($id = NULL)
	{
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item == NULL) 
		{
			redirect($this->_redirect_url);
		}
		
		$category = $this->merchants_model->get_shop_category($id);
		
		$merchant = $this->merchants_model->get_payment_merchant($item['merchant_id']);
		
		
		// setup page header data
        $this->set_title(sprintf(lang('users shops merchant'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
					'user'              => $user,
					'category'    => $category,
					'id'      => $id,
					'item'      => $item,
					'merchant'      => $merchant,
        );

        // load views
        $data['content'] = $this->load->view('account/shops/detail_item', $content_data, TRUE);
        $this->load->view($this->template, $data);
		
	}
	
	function confirm()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('merchant', lang('users shops id'), 'required|trim|numeric|callback__check_merchant[]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		$this->form_validation->set_rules('id_payment', lang('users shops merchant_note'), 'required|trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users shops merchant_pay_error'));
			redirect(site_url("account/shops"));

		} else {
			
			$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
			$currency = $this->input->post("currency", TRUE);
			$merchant_id = $this->input->post("merchant", TRUE);
			$id_payment = $this->input->post("id_payment", TRUE);
			
			// get the data
    	$merchant = $this->merchants_model->get_payment_merchant($merchant_id);
			
			if ($currency == "debit_base") {
				$symbol = $this->currencys->display->base_code;
			} elseif ($currency == "debit_extra1") {
				$symbol = $this->currencys->display->extra1_code;
			} elseif ($currency == "debit_extra2") {
				$symbol = $this->currencys->display->extra2_code;
			} elseif ($currency == "debit_extra3") {;
				$symbol = $this->currencys->display->extra3_code;
			} elseif ($currency =="debit_extra4") {
				$symbol = $this->currencys->display->extra4_code;
			} elseif ($currency =="debit_extra5") {
				$symbol = $this->currencys->display->extra5_code;
			} else {
					
					$this->session->set_flashdata('error', lang('users shops merchant_pay_error'));
					redirect(site_url("account/shops"));
					
			}
			
			// Who pays the fees?
			if ($merchant['payeer_fee'] == "0") {
				
				$total_fee = "0.00";
				$total_amount = number_format($amount, 2, '.', '');
				
			} else {
				
				// Calculation of the commission and total sum
				$percent = $merchant['fee']/"100";
				$percent_fee = $amount * $percent;
				$total_fee_calc = $percent_fee + $merchant['fix_fee'];
				$total_fee = number_format($total_fee_calc, 2, '.', '');
				$total_amount_calc = $amount + $total_fee;
				$total_amount = number_format($total_amount_calc, 2, '.', '');
				
			}

		}
		
		// setup page header data
		$this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));

		$data = $this->includes;
		
		// set content data
     $content_data = array(
     	'user'              => $user,
      'merchant'      => $merchant,
			'amount'              => $amount,
			'currency'              => $currency,
			'symbol'     => $symbol,
			'total_amount'              => $total_amount,
			'total_fee'              => $total_fee,
			'id_payment'              => $id_payment,
     );

     // load views
     $data['content'] = $this->load->view('account/shops/confirm', $content_data, TRUE);
     $this->load->view($this->template, $data);
		
	}
	
	function start_payment()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('merchant', lang('users shops id'), 'required|trim|numeric|callback__check_merchant[]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		$this->form_validation->set_rules('id_payment', lang('users shops merchant_note'), 'required|trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users shops merchant_pay_error'));
			redirect(site_url("account/shops"));

		} else {
			
			$amount = number_format($this->input->post("amount", TRUE), 2, '.', '');
			$currency = $this->input->post("currency", TRUE);
			$merchant_id = $this->input->post("merchant", TRUE);
			$id_payment = $this->input->post("id_payment", TRUE);
			
			// get the data
    	$merchant = $this->merchants_model->get_payment_merchant($merchant_id);
			
			if ($currency == "debit_base") {
				$symbol = $this->currencys->display->base_code;
			} elseif ($currency == "debit_extra1") {
				$symbol = $this->currencys->display->extra1_code;
			} elseif ($currency == "debit_extra2") {
				$symbol = $this->currencys->display->extra2_code;
			} elseif ($currency == "debit_extra3") {;
				$symbol = $this->currencys->display->extra3_code;
			} elseif ($currency =="debit_extra4") {
				$symbol = $this->currencys->display->extra4_code;
			} elseif ($currency =="debit_extra5") {
				$symbol = $this->currencys->display->extra5_code;
			} else {
					
					$this->session->set_flashdata('error', lang('users shops merchant_pay_error'));
					redirect(site_url("account/shops"));
					
			}
			
			
			// Calculation of the commission and total sum
			$percent = $merchant['fee']/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $merchant['fix_fee'];
			$total_fee = number_format($total_fee_calc, 2, '.', '');
			$total_amount_calc = $amount + $total_fee;
			$total_amount = number_format($total_amount_calc, 2, '.', '');
			
			// Who pays the fees?
			if ($merchant['payeer_fee'] == "0") {
				
				if ($user[$currency] >= $amount) {
				
					$label = uniqid("ssp_");

					// Check user merchant
					$merchant_user = $this->users_model->get_username($merchant['user']);

					// user wallet total
					$wallet_total_user = $user[$currency] - $amount;
					
					$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);
					
					// check user hold balance
					if ($wallet_total_user < $hold_balance) {
						
						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url("account/shops"));
						
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
							"time"          	=> date('Y-m-d H:i:s'),
							"label" 	    => $label,
							"admin_comment" 	    => "merchant fee",
							"user_comment" 	    => $id_payment,
							"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
							"protect" 	    => "none",
							)
						);

						$this->session->set_flashdata('message', lang('users shops confirm_success'));
						redirect(site_url("account/transactions"));
						
					}


				} else {
				
					// no money to pay
					$this->session->set_flashdata('error', lang('users error wallet'));
					redirect(site_url("account/shops"));
				
				}
				
			} else {
				
				if ($user[$currency] >= $total_amount) {
				
					$label = uniqid("ssp_");

					// Check user merchant
					$merchant_user = $this->users_model->get_username($merchant['user']);

					// user wallet total
					$wallet_total_user = $user[$currency] - $total_amount;

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
						"time"          	=> date('Y-m-d H:i:s'),
						"label" 	    => $label,
						"admin_comment" 	    => "none",
						"user_comment" 	    => $id_payment,
						"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
						"protect" 	    => "none",
						)
					);

					$this->session->set_flashdata('message', lang('users shops confirm_success'));
					redirect(site_url("account/transactions"));

				} else {
				
				// no money to pay
        $this->session->set_flashdata('error', lang('users error wallet'));
				redirect(site_url("account/shops"));
				
			}
				
				
			}
			
		}
		
	}
	
	function search()
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
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$shops = $this->merchants_model->get_shops_search($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$shops = $this->merchants_model->get_shops_search($limit, $offset, $filters, $sort, $dir);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $shops['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
			'category'   => $category,
            'this_url'   => THIS_URL_3,
            'shops'    => $shops['results'],
            'total'      => $shops['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/shops/search', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	function add_to_cart($id = NULL)
	{
		
		$user = $this->users_model->get_user($this->user['id']);
    
    // make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item == NULL) 
		{
			redirect($this->_redirect_url);
		}
		
		if ($item['status'] == 1 && $item['availability'] > 0) {
			
			$cart = $this->cart_model->add_cart(array(
      	"id_item" 				=> $id,
				"id_merchant" 				=> $item['merchant_id'],
				"user" 				=> $user['username'],
				"date" 				=> date('Y-m-d H:i:s'),
        )
      );
			
			$this->session->set_flashdata('message', lang('users cart success_to_cart'));
      redirect(site_url('account/shops/items/'.$item['category_id'].''));
			
		} else {
			
			$this->session->set_flashdata('error', lang('users cart fail_to_cart'));
      redirect(site_url('account/shops/items/'.$item['category_id'].''));
			
		}
		
	}
	
	function add_to_cart_item($id = NULL)
	{
		
		$user = $this->users_model->get_user($this->user['id']);
    
    // make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item == NULL) 
		{
			redirect($this->_redirect_url);
		}
		
		if ($item['status'] == 1 && $item['availability'] > 0) {
			
			$cart = $this->cart_model->add_cart(array(
      	"id_item" 				=> $id,
				"id_merchant" 				=> $item['merchant_id'],
				"user" 				=> $user['username'],
				"date" 				=> date('Y-m-d H:i:s'),
        )
      );
			
			$this->session->set_flashdata('message', lang('users cart success_to_cart'));
      redirect(site_url('account/shops/detail_item/'.$item['id'].''));
			
		} else {
			
			$this->session->set_flashdata('error', lang('users cart fail_to_cart'));
      redirect(site_url('account/shops/detail_item/'.$item['id'].''));
			
		}
		
	}
	
	function buy_now($id = NULL)
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item == NULL) 
		{
			redirect($this->_redirect_url);
		}
		
		if ($item['availability'] > 0) {
			
			$merchant = $this->merchants_model->get_sci_merchant($item['merchant_id']);
    
			// Check user merchant
			$merchant_user = $this->users_model->get_username($merchant['user']);

			$currency = $item['currency'];
			$amount = $item['price'];

			// Calculation of the commission and total sum
			$percent = $merchant['fee']/"100";
			$percent_fee = $amount * $percent;
			$total_fee_calc = $percent_fee + $merchant['fix_fee'];
			$total_fee = number_format($total_fee_calc, 2, '.', '');
			$total_amount_calc = $amount + $total_fee;
			$total_amount = number_format($total_amount_calc, 2, '.', '');
			
			if ($user['username'] == $merchant['user']) {
				
				$this->session->set_flashdata('error', lang('users error fraud'));
				redirect(site_url('account/shops/detail_item/'.$item['id'].''));
				
			}

			// Who pays the fees?
			if ($merchant['payeer_fee'] == "0") {

				if ($user[$currency] >= $amount) {

					$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);

					// user wallet total
					$wallet_total_user = $user[$currency] - $amount;

					// check user hold balance
					if ($wallet_total_user < $hold_balance) {

						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url('account/shops/detail_item/'.$item['id'].''));

					} else {

						$date = date('Y-m-d H:i:s');

						$label = uniqid("sap_");

						$code = uniqid("itm_");

						// user wallet total
						$wallet_total_user = $user[$currency] - $amount;

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
							"user_comment" 	    => $item['name'],
							"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
							"protect" 	    => "none",
							"merchant" => $merchant['id'],
							"payer_fee" => "1",
							)
						);

						// total availability
						$total_items = $item['availability'] - 1;

						// update availability
						$this->merchants_model->update_item($item['id'],
							array(
								"availability" => $total_items,
							)
						);

						$id_transaction = $this->transactions_model->get_label($label);

						// add order
						$order = $this->orders_model->add_order(array(
							"code" 				=> $code,
							"date"        => $date,
							"id_item"     => $item['id'],
							"id_transaction"     => $id_transaction['id'],
							"id_merchant"        => $merchant['id'],
							"user"        => $user['username'],
							)
						);

						$this->session->set_flashdata('message', lang('users cart success'));
						redirect(site_url("account/orders"));

					}

				} else {

					$this->session->set_flashdata('error', lang('users error wallet'));
					redirect(site_url('account/shops/detail_item/'.$item['id'].''));

				}

			} else {

				if ($user[$currency] >= $total_amount) {

					$date = date('Y-m-d H:i:s');

					$label = uniqid("sap_");

					$code = uniqid("itm_");

					// user wallet total
					$wallet_total_user = $user[$currency] - $total_amount;

					// check user hold balance
					if ($wallet_total_user < $hold_balance) {

						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url('account/shops/detail_item/'.$item['id'].''));

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
							"user_comment" 	    => $item['name'],
							"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
							"protect" 	    => "none",
							"merchant" => $merchant['id'],
							)
						);

						$id_transaction = $this->transactions_model->get_label($label);
						
						// total availability
						$total_items = $item['availability'] - 1;

						// update availability
						$this->merchants_model->update_item($item['id'],
							array(
								"availability" => $total_items,
							)
						);

						// add order
						$order = $this->orders_model->add_order(array(
							"code" 				=> $code,
							"date"        => $date,
							"it_item"     => $item['id'],
							"it_transaction"     => $id_transaction['id'],
							"id_merchant"        => $merchant['id'],
							"user"        => $user['username'],
							)
						);

						$this->session->set_flashdata('message', lang('users cart success'));
						redirect(site_url("account/orders"));

					}

				} else {

					$this->session->set_flashdata('error', lang('users error wallet'));
					redirect(site_url('account/shops/detail_item/'.$item['id'].''));

				}


			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users cart not_aviable'));
      redirect(site_url('account/shops/detail_item/'.$item['id'].''));
			
		}
		
	}
	
	  /**************************************************************************************
    * PRIVATE VALIDATION CALLBACK FUNCTIONS
 **************************************************************************************/
	
	/**
     * Make sure category is available
     *
     * @param  string $username
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_merchant($id)
    {
        if ($this->merchants_model->category_merchant($id))
        {
            $this->form_validation->set_message('_check_merchant', sprintf(lang('users error username_exists'), $id));
						return $id;
        }
        else
        {
            return FALSE;
        }
    }
  
}