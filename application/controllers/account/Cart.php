<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Cart extends Private_Controller {

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
        $this->load->model('transactions_model');
        
		// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/cart'));
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
	* Main page
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
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->cart_model->get_user_cart($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users cart title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->cart_model->get_user_cart($limit, $offset, $filters, $sort, $dir, $user['username']);
					
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
        $data['content'] = $this->load->view('account/cart/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

	/**
	* Remove item from cart
    */
	
	function del_item($id = NULL)
	{
		
		$user = $this->users_model->get_user($this->user['id']);
    
	    // make sure we have a numeric id
	    if (is_null($id) OR ! is_numeric($id))
	    {
	       redirect($this->_redirect_url);
	    }
		
		$cart = $this->cart_model->get_cart($id);

		// make sure this item in the user's cart
		if ($cart['user'] == $user['username']) {
			
			// remove item from the cart
      		$delete = $this->cart_model->delete_cart($cart['id']);
			
			$this->session->set_flashdata('message', lang('users cart del_success'));
      		redirect(site_url("account/cart"));
			
		} else {
			
			redirect(site_url("account/cart"));
			
		}
		
	}

	/**
	* Pay item from cart
    */
  
  	function pay_item($id = NULL)
	{
    
	    $user = $this->users_model->get_user($this->user['id']);
	    
	    // make sure we have a numeric id
	    if (is_null($id) OR ! is_numeric($id))
	    {
	       redirect($this->_redirect_url);
	    }
			
		$cart = $this->cart_model->get_cart($id);
	    
	    $item = $this->merchants_model->get_item($cart['id_item']);
			
		if ($item == NULL) 
		{
			redirect($this->_redirect_url);
		}

		if ($item == NULL) 
		{
			redirect($this->_redirect_url);
		}
			
		

		if ($user['fraud'] == 0) {

			if ($user['login_status'] == 2) {

				if ($item['availability'] > 0) {
				
				$merchant = $this->merchants_model->get_sci_merchant($item['merchant_id']);
					
				if ($user['username'] == $merchant['user']) {
				
					$this->session->set_flashdata('error', lang('users error fraud'));
					redirect(site_url('account/cart'));
				
				}
		    
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

				// Who pays the fees?
				if ($merchant['payeer_fee'] == "0") {

					if ($user[$currency] >= $amount) {

						$hold_balance = $this->transactions_model->hold_balance($user['username'], $currency);

						// user wallet total
						$wallet_total_user = $user[$currency] - $amount;

						// check user hold balance
						if ($wallet_total_user < $hold_balance) {

							$this->session->set_flashdata('error', lang('users error wallet'));
							redirect(site_url("account/cart"));

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
								"currency"			=> $currency,
								"status" 			=> "2",
								"sender" 			=> $user['username'],
								"receiver" 			=> $merchant['user'],
								"time"          	=> $date,
								"label" 	    	=> $label,
								"admin_comment" 	=> "merchant fee",
								"user_comment" 	    => $item['name'],
								"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
								"protect" 	    	=> "none",
								"merchant" 			=> $merchant['id'],
								"payer_fee" 		=> "1",
								)
							);

							$id_transaction = $this->transactions_model->get_label($label);

							// add order
							$order = $this->orders_model->add_order(array(
								"code" 				=> $code,
								"date"        		=> $date,
								"id_item"     		=> $item['id'],
								"id_transaction"    => $id_transaction['id'],
								"id_merchant"       => $merchant['id'],
								"user"        		=> $user['username'],
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

							// remove item from the cart
							$delete = $this->cart_model->delete_cart($cart['id']);

							$this->session->set_flashdata('message', lang('users cart success'));
							redirect(site_url("account/cart"));

						}

					} else {

						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url("account/cart"));

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
							redirect(site_url("account/cart"));

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
								"currency"			=> $currency,
								"status" 			=> "2",
								"sender" 			=> $user['username'],
								"receiver" 			=> $merchant['user'],
								"time"          	=> $date,
								"label" 	    	=> $label,
								"admin_comment" 	=> "none",
								"user_comment" 	    => $item['name'],
								"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
								"protect" 	    	=> "none",
								"merchant" 			=> $merchant['id'],
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
								"date"        		=> $date,
								"id_item"     		=> $item['id'],
								"id_transaction"    => $id_transaction['id'],
								"id_merchant"       => $merchant['id'],
								"user"        		=> $user['username'],
								)
							);

							// remove item from the cart
							$delete = $this->cart_model->delete_cart($cart['id']);

							$this->session->set_flashdata('message', lang('users cart success'));
							redirect(site_url("account/cart"));

						}

					} else {

						$this->session->set_flashdata('error', lang('users error wallet'));
						redirect(site_url("account/cart"));

					}


				}
					
			} else {
					
				$this->session->set_flashdata('error', lang('users cart not_aviable'));
		      	redirect(site_url("account/cart"));
					
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