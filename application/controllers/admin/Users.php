<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

    /**
     * @var string
     */
    private $_redirect_url;


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
				$this->load->model('support_model');
				$this->load->model('settings_model');
				$this->load->model('events_model');
				$this->load->model('merchants_model');
				$this->load->model('verification_model');
				$this->load->model('transactions_model');
				$this->load->model('cart_model');
				$this->load->model('orders_model');
				$this->load->model('template_model');
				$this->load->model('invoices_model');
				$this->load->library('notice');
				$this->load->library('currencys');
				$this->load->library('email');

        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/users'));
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


    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/


    /**
     * User list page
     */
    function index()
    {
        // get parameters
        $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
        $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;

        // get filters
        $filters = array();

        if ($this->input->get('username'))
        {
						$username_xss = $this->security->xss_clean($this->input->get('username'));
						$username_replace = htmlentities($username_xss, ENT_QUOTES, "UTF-8");
            $filters['username'] = $username_replace;
        }
			
				if ($this->input->get('email'))
        {
						$email_xss = $this->security->xss_clean($this->input->get('email'));
						$username_replace = htmlentities($email_xss, ENT_QUOTES, "UTF-8");
            $filters['email'] = $username_replace;
        }

        if ($this->input->get('first_name'))
        {
						$first_name_xss = $this->security->xss_clean($this->input->get('first_name'));
						$first_name_replace = htmlentities($first_name_xss, ENT_QUOTES, "UTF-8");
            $filters['first_name'] = $first_name_replace;
        }

        if ($this->input->get('last_name'))
        {
						$last_name_xss = $this->security->xss_clean($this->input->get('last_name'));
						$last_name_replace = htmlentities($last_name_xss, ENT_QUOTES, "UTF-8");
            $filters['last_name'] = $last_name_replace;
        }

        // build filter string
        $filter = "";
        foreach ($filters as $key => $value)
        {
            $filter .= "&{$key}={$value}";
        }

        // save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");

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

                if ($this->input->post('username'))
                {
                    $filter .= "&username=" . $this->input->post('username', TRUE);
                }
								if ($this->input->post('email'))
                {
                    $filter .= "&email=" . $this->input->post('email', TRUE);
                }

                if ($this->input->post('first_name'))
                {
                    $filter .= "&first_name=" . $this->input->post('first_name', TRUE);
                }

                if ($this->input->post('last_name'))
                {
                    $filter .= "&last_name=" . $this->input->post('last_name', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
        }

        // get list
        $users = $this->users_model->get_all($limit, $offset, $filters, $sort, $dir);

        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $users['total'],
            'per_page'   => $limit
        ));

        // setup page header data
		$this
			->add_js_theme('users_i18n.js', TRUE )
			->set_title(lang('users title user_list'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'users'      => $users['results'],
            'total'      => $users['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/users/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**
     * Add new user
     */
    function add()
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('users input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username[]');
        $this->form_validation->set_rules('first_name', lang('users input first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('users input last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[128]|valid_email|callback__check_email[]');
        $this->form_validation->set_rules('language', lang('users input language'), 'required|trim');
        $this->form_validation->set_rules('status', lang('users input status'), 'required|numeric');
        $this->form_validation->set_rules('is_admin', lang('users input is_admin'), 'required|numeric');
        $this->form_validation->set_rules('password', lang('users input password'), 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'required|trim|matches[password]');

        if ($this->form_validation->run() == TRUE)
        {
            // save the new user
            $saved = $this->users_model->add_user($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('users msg add_user_success'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('users error add_user_failed'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title(lang('users title user_add'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'user'              => NULL,
            'password_required' => TRUE
        );

        // load views
        $data['content'] = $this->load->view('admin/users/add', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
		
		function edit_billing($id=NULL)
    {
			
			// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $user = $this->users_model->get_user($id);
			
				// if empty results, return to list
        if ( ! $user)
        {
            redirect($this->_redirect_url);
        }
			
				$this->form_validation->set_rules('paypal', lang('admin user paypal'), 'trim');
				$this->form_validation->set_rules('card', lang('admin user card'), 'trim|numeric');
				$this->form_validation->set_rules('bitcoin', lang('admin user bitcoin'), 'trim');
				$this->form_validation->set_rules('skrill', lang('admin user skrill'), 'trim');
				$this->form_validation->set_rules('payza', lang('admin user payza'), 'trim');
				$this->form_validation->set_rules('advcash', lang('admin user advcash'), 'trim');
				$this->form_validation->set_rules('perfect_m', lang('perfect_m'), 'trim');
				$this->form_validation->set_rules('swift', lang('perfect_m'), 'trim');
			
				if ($this->form_validation->run() == TRUE)
        {
					$post_data = $this->security->xss_clean($this->input->post());
					$update_user = $this->users_model->update_setting_user($id, $post_data);
					$this->session->set_flashdata('message', lang('admin user success'));
					redirect(site_url("admin/users"));
				} else {
					$this->session->set_flashdata('error', lang('admin user error'));
					redirect(site_url("admin/users"));
				}
		}
	
	function edit_security($id=NULL)
    {
			
			// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $user = $this->users_model->get_user($id);
			
				// if empty results, return to list
        if ( ! $user)
        {
            redirect($this->_redirect_url);
        }
			
				$this->form_validation->set_rules('phone', lang('admins input phone'), 'trim|numeric');
				$this->form_validation->set_rules('method_login', lang('admin security login_method'), 'trim|numeric|in_list[1,2,3,4]');
				$this->form_validation->set_rules('login_status', lang('admin security lstatus_0'), 'trim|numeric|in_list[1,2]');
				$this->form_validation->set_rules('fraud', lang('admin security fraud_status'), 'trim|numeric|in_list[0,1]');
			
				if ($this->form_validation->run() == TRUE)
        {
					$post_data = $this->security->xss_clean($this->input->post());
					$update_user = $this->users_model->update_setting_user($id, $post_data);
					$this->session->set_flashdata('message', lang('admin user success'));
					redirect(site_url("admin/users"));
				} else {
					$this->session->set_flashdata('error', lang('admin user error'));
					redirect(site_url("admin/users"));
				}
		}
	
	function add_funds($id=NULL)
	{
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
    	redirect($this->_redirect_url);
    }

    // get the data
    $user = $this->users_model->get_user($id);
			
		// if empty results, return to list
    if ( ! $user)
    {
    	redirect($this->_redirect_url);
    }
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users error form'));
			redirect(site_url("admin/users"));
			
		} else {
			
			$note = $this->input->post("note", TRUE);
			$amount = $this->input->post("amount", TRUE);
			$currency = $this->input->post("currency", TRUE);
			
			$label = uniqid("adt_");
			
			$total_receiver = $user[$currency]+$amount;
			
			// update receiver wallet
			$this->users_model->update_wallet_transfer($user['username'],
				array(
					$currency => $total_receiver,
				)
			);
			
			// add transaction for sender
			$transactions = $this->transactions_model->add_transaction(array(
				"type" 				=> "1",
				"sum"  				=> $this->input->post("amount", TRUE),
				"fee"    			=> "0.00",
				"amount" 			=> $this->input->post("amount", TRUE),
				"currency"		=> $this->input->post("currency", TRUE),
				"status" 			=> "2",
				"sender" 			=> "system",
				"receiver" 		=> $user['username'],
				"time"        => date('Y-m-d H:i:s'),
				"user_comment"  	=> $note,
				"label" 	    		=> $label,
				"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
				"protect" 	    	=> "none",
				)
			);
			
			$this->session->set_flashdata('message', lang('users transfer success'));
			redirect(site_url("admin/users"));
			
		}
		
	}
	
	function to_funds($id=NULL)
	{
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
    	redirect($this->_redirect_url);
    }

    // get the data
    $user = $this->users_model->get_user($id);
			
		// if empty results, return to list
    if ( ! $user)
    {
    	redirect($this->_redirect_url);
    }
		
		$this->form_validation->set_rules('amount', lang('users transfer amount'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_flashdata('error', lang('users error form'));
			redirect(site_url("admin/users"));
			
		} else {
			
			$note = $this->input->post("note", TRUE);
			$amount = $this->input->post("amount", TRUE);
			$currency = $this->input->post("currency", TRUE);
			
			$label = uniqid("adt_");
			
			$total_receiver = $user[$currency]-$amount;
			
			// update receiver wallet
			$this->users_model->update_wallet_transfer($user['username'],
				array(
					$currency => $total_receiver,
				)
			);
			
			// add transaction for sender
			$transactions = $this->transactions_model->add_transaction(array(
				"type" 				=> "2",
				"sum"  				=> $this->input->post("amount", TRUE),
				"fee"    			=> "0.00",
				"amount" 			=> $this->input->post("amount", TRUE),
				"currency"		=> $this->input->post("currency", TRUE),
				"status" 			=> "2",
				"sender" 			=> "system",
				"receiver" 		=> $user['username'],
				"time"        => date('Y-m-d H:i:s'),
				"user_comment"  	=> $note,
				"label" 	    		=> $label,
				"ip_address" 	    => $_SERVER["REMOTE_ADDR"],
				"protect" 	    	=> "none",
				)
			);
			
			$this->session->set_flashdata('message', lang('admin profit 17'));
			redirect(site_url("admin/users"));
			
		}
		
	}
	
	function send_sms($id=NULL)
	{
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
    	redirect($this->_redirect_url);
    }

    // get the data
    $user = $this->users_model->get_user($id);
			
		// if empty results, return to list
    if ( ! $user)
    {
    	redirect($this->_redirect_url);
    }
		
		$this->form_validation->set_rules('phone', lang('admins input phone'), 'trim|numeric');
		$this->form_validation->set_rules('message', lang('admin tickets message'), 'required');
		
		if ($this->form_validation->run() == TRUE)
    {
			
			$result = $this->sms->send_sms($user['phone'], $this->input->post('message', TRUE));
			
			if ($result == TRUE) {
				
				$this->session->set_flashdata('message', lang('admin security success_sms'));
				redirect(site_url("admin/users"));
				
			} else {
				
				$this->session->set_flashdata('error', lang('admin security fail_sms'));
				redirect(site_url("admin/users"));
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('admin security form_error_sms'));
			redirect(site_url("admin/users"));
			
		}
		
		
	}
	
	function send_email($id=NULL)
	{
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
    	redirect($this->_redirect_url);
    }

    // get the data
    $user = $this->users_model->get_user($id);
			
		// if empty results, return to list
    if ( ! $user)
    {
    	redirect($this->_redirect_url);
    }
		
		$this->form_validation->set_rules('email', lang('admin user email'), 'required');
		$this->form_validation->set_rules('title', lang('admins tickets title'), 'required');
		$this->form_validation->set_rules('message', lang('admin tickets message'), 'required');
		
		if ($this->form_validation->run() == TRUE)
    {
			
			$email_template = $this->template_model->get_email_template(30);
			
			if ($email_template['status'] == 1) {
				
				// variables to replace
				$site_name = $this->settings->site_name;
				$message = $this->input->post('message', TRUE);
				$title = $this->input->post('title', TRUE);
				$name_user = $user['first_name'] . ' ' . $user['last_name'];

				$rawstring = $email_template['message'];
				
				// what will we replace
				$placeholders = array('[SITE_NAME]', '[TITLE]', '[MESSAGE]', '[NAME]');

				$vals_1 = array($site_name, $title, $message, $name_user);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);
				
				$this -> email -> from($this->settings->site_email, $this->settings->site_name);
				$this->email->to($user['email']);
				$this -> email -> subject($title);

				$this -> email -> message($str_1);

				$this->email->send();
				
				$this->session->set_flashdata('message', lang('admin security success_sms'));
				redirect(site_url("admin/users"));
				
			} else {
				
				$this->session->set_flashdata('error', lang('admin security disabled_email'));
				redirect(site_url("admin/users"));
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('admin security form_error_sms'));
			redirect(site_url("admin/users"));
			
		}
		
		
	}
	
	  function edit_verify($id=NULL)
    {
			
			// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $user = $this->users_model->get_user($id);
			
				// if empty results, return to list
        if ( ! $user)
        {
            redirect($this->_redirect_url);
        }
			
				$this->form_validation->set_rules('company', lang('admin verify company'), 'required');
				$this->form_validation->set_rules('country', lang('admin verify country'), 'required');
				$this->form_validation->set_rules('zip', lang('admin verify zip'), 'required');
				$this->form_validation->set_rules('city', lang('admin verify city'), 'required');
				$this->form_validation->set_rules('address_1', lang('admin verify address_1'), 'required');
				$this->form_validation->set_rules('address_2', lang('admin verify address_2'), 'required');
			
				if ($this->form_validation->run() == TRUE)
        {
					$post_data = $this->security->xss_clean($this->input->post());
					$update_user = $this->users_model->update_setting_user($id, $post_data);
					$this->session->set_flashdata('message', lang('admin user success'));
					redirect(site_url("admin/users"));
				} else {
					$this->session->set_flashdata('error', lang('admin user error'));
					redirect(site_url("admin/users"));
				}
		}

    /**
     * Edit existing user
     *
     * @param  int $id
     */
    function edit($id=NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $user = $this->users_model->get_user($id);

        // if empty results, return to list
        if ( ! $user)
        {
            redirect($this->_redirect_url);
        }

        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('users input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username[' . $user['username'] . ']');
        $this->form_validation->set_rules('first_name', lang('users input first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('users input last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[128]|valid_email|callback__check_email[' . $user['email'] . ']');
				$this->form_validation->set_rules('verify_status', lang('admin verify user_menu'), 'required|numeric|in_list[0,1,2]');
        $this->form_validation->set_rules('language', lang('users input language'), 'required|trim');
        $this->form_validation->set_rules('status', lang('users input status'), 'required|numeric|in_list[0,1]');
        $this->form_validation->set_rules('is_admin', lang('users input is_admin'), 'required|numeric|in_list[0,1]');
        $this->form_validation->set_rules('password', lang('users input password'), 'min_length[5]|matches[password_repeat]');
        $this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'matches[password]');
			
				$log_user = $this->events_model->get_events_user_admin($user['username']);
			
				$transaction_user = $this->transactions_model->get_transaction_user_admin($user['username']);
			
				$support_user = $this->support_model->get_support_user_admin($user['username']);
			
				$merchant_user = $this->merchants_model->get_merchant_user_admin($user['username']);
			
				$inv_user = $this->invoices_model->get_invoices_user_admin($user['username']);
			
				$documents = $this->verification_model->get_user_request($user['username']);
			
				$rel_accounts = $this->users_model->get_rel_user_admin($user['ip_address']);
			
				$carts = $this->cart_model->get_admin_cart($user['username']);
			
				$orders = $this->orders_model->get_admin_orders($user['username']);
			
				$profit_debit_base = $this->transactions_model->profit_user_debit_base($user['username']);
			
				$profit_debit_extra1 = $this->transactions_model->profit_user_debit_extra1($user['username']);
			
				$profit_debit_extra2 = $this->transactions_model->profit_user_debit_extra2($user['username']);
			
				$profit_debit_extra3 = $this->transactions_model->profit_user_debit_extra3($user['username']);
			
				$profit_debit_extra4 = $this->transactions_model->profit_user_debit_extra4($user['username']);
			
				$profit_debit_extra5 = $this->transactions_model->profit_user_debit_extra5($user['username']);

        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->users_model->edit_user($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('users msg edit_user_success'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('users error edit_user_failed'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title(lang('users title user_edit'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'user'              => $user,
            'user_id'           => $id,
						'profit_debit_base'          => $profit_debit_base,
						'profit_debit_extra1'          => $profit_debit_extra1,
						'profit_debit_extra2'          => $profit_debit_extra2,
						'profit_debit_extra3'          => $profit_debit_extra3,
						'profit_debit_extra4'          => $profit_debit_extra4,
						'profit_debit_extra5'          => $profit_debit_extra5,
						'log_user'          => $log_user,
						'inv_user'          => $inv_user,
						'support_user'          => $support_user,
						'rel_accounts'          => $rel_accounts,
						'merchant_user'          => $merchant_user,
						'transaction_user'          => $transaction_user,
						'documents'         => $documents,
						'carts'         => $carts,
						'orders'         => $orders,
            'password_required' => FALSE
        );

        // load views
        $data['content'] = $this->load->view('admin/users/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**
     * Delete a user
     *
     * @param  int $id
     */
    function delete($id=NULL)
    {
        // make sure we have a numeric id
        if ( ! is_null($id) OR ! is_numeric($id))
        {
            // get user details
            $user = $this->users_model->get_user($id);

            if ($user)
            {
                // soft-delete the user
                $delete = $this->users_model->delete_user($id);

                if ($delete)
                {
                    $this->session->set_flashdata('message', sprintf(lang('users msg delete_user'), $user['first_name'] . " " . $user['last_name']));
                }
                else
                {
                    $this->session->set_flashdata('error', sprintf(lang('users error delete_user'), $user['first_name'] . " " . $user['last_name']));
                }
            }
            else
            {
                $this->session->set_flashdata('error', lang('users error user_not_exist'));
            }
        }
        else
        {
            $this->session->set_flashdata('error', lang('users error user_id_required'));
        }

        // return to list and display message
        redirect($this->_redirect_url);
    }


    /**
     * Export list to CSV
     */
    function export()
    {
        // get parameters
        $sort = $this->input->get('sort') ? $this->input->get('sort', TRUE) : DEFAULT_SORT;
        $dir  = $this->input->get('dir')  ? $this->input->get('dir', TRUE)  : DEFAULT_DIR;

        // get filters
        $filters = array();

        if ($this->input->get('username'))
        {
            $filters['username'] = $this->input->get('username', TRUE);
        }

        if ($this->input->get('first_name'))
        {
            $filters['first_name'] = $this->input->get('first_name', TRUE);
        }

        if ($this->input->get('last_name'))
        {
            $filters['last_name'] = $this->input->get('last_name', TRUE);
        }

        // get all users
        $users = $this->users_model->get_all(0, 0, $filters, $sort, $dir);

        if ($users['total'] > 0)
        {
            // manipulate the output array
            foreach ($users['results'] as $key=>$user)
            {
                unset($users['results'][$key]['password']);
                unset($users['results'][$key]['deleted']);

                if ($user['status'] == 0)
                {
                    $users['results'][$key]['status'] = lang('admin input inactive');
                }
                else
                {
                    $users['results'][$key]['status'] = lang('admin input active');
                }
            }

            // export the file
            array_to_csv($users['results'], "users");
        }
        else
        {
            // nothing to export
            $this->session->set_flashdata('error', lang('core error no_results'));
            redirect($this->_redirect_url);
        }

        exit;
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
            return FALSE;
        }
        else
        {
            return $username;
        }
    }


    /**
     * Make sure email is available
     *
     * @param  string $email
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_email($email, $current)
    {
        if (trim($email) != trim($current) && $this->users_model->email_exists($email))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_exists'), $email));
            return FALSE;
        }
        else
        {
            return $email;
        }
    }

}
