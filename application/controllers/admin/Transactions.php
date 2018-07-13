<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends Admin_Controller {
  
  /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
      
        // load the language files
        $this->lang->load('users');

        // load the language files
        $this->load->model('transactions_model');
				$this->load->model('support_model');
				$this->load->model('verification_model');
				$this->load->model('merchants_model');
				$this->load->model('users_model');
				$this->load->model('template_model');
				$this->load->library('notice');
        $this->load->library('currencys');
      
      
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/transactions'));
        define('THIS_URL_2', base_url('admin/transactions/pending'));
        define('THIS_URL_3', base_url('admin/transactions/confirmed'));
        define('THIS_URL_4', base_url('admin/transactions/disputed'));
        define('THIS_URL_5', base_url('admin/transactions/blocked'));
        define('THIS_URL_6', base_url('admin/transactions/refunded'));
				define('THIS_URL_7', base_url('admin/transactions/vouchers'));
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
    function vouchers()
    {
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
						$id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
						$filters['id'] = $id_string;
        }

        if ($this->input->get('code'))
        {
						$code_xss = $this->security->xss_clean($this->input->get('code'));
						$code_string = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
						$filters['code'] = $code_string;
        }
      
        if ($this->input->get('date_creature'))
        {
						$date_creature_xss = $this->security->xss_clean($this->input->get('date_creature'));
						$date_creature_string = htmlentities($date_creature_xss, ENT_QUOTES, "UTF-8");
						$filters['date_creature'] = $date_creature_string;
        }
      
        if ($this->input->get('date_activation'))
        {
						$date_activation_xss = $this->security->xss_clean($this->input->get('date_activation'));
						$date_activation_replace = htmlentities($date_activation_xss, ENT_QUOTES, "UTF-8");
            $filters['date_activation'] = $date_activation_replace;
        }
      
        if ($this->input->get('creator'))
        {
						$creator_xss = $this->security->xss_clean($this->input->get('creator'));
						$creator_replace = htmlentities($creator_xss, ENT_QUOTES, "UTF-8");
            $filters['creator'] = $creator_replace;
        }
			
				if ($this->input->get('activator'))
        {
						$activator_xss = $this->security->xss_clean($this->input->get('activator'));
						$activator_replace = htmlentities($activator_xss, ENT_QUOTES, "UTF-8");
            $filters['activator'] = $activator_replace;
        }

        if ($this->input->get('status'))
        {
						$status_xss = $this->security->xss_clean($this->input->get('status'));
						$status_replace = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
            $filters['status'] = $status_replace;
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
                redirect(THIS_URL_7);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('code'))
                {
                    $filter .= "&code=" . $this->input->post('code', TRUE);
                }
              
                if ($this->input->post('date_creature'))
                {
                    $filter .= "&date_creature=" . $this->input->post('date_creature', TRUE);
                }
              
                if ($this->input->post('date_activation'))
                {
                    $filter .= "&date_activation=" . $this->input->post('date_activation', TRUE);
                }
              
                if ($this->input->post('creator'))
                {
                    $filter .= "&creator=" . $this->input->post('creator', TRUE);
                }

                if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }
							
								if ($this->input->post('activator'))
                {
                    $filter .= "&activator=" . $this->input->post('activator', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_7 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_all_vouchers($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_7 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_all_vouchers($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_7 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL_7,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/vouchers', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	
	 /**
     * Hold voucher
     */
	function block_voucher($id = NULL)
  {
		
     // make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_vouchers($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		if ($transactions['status'] != 3 & $transactions['status'] == 1) {
			
			// update transaction history
			$this->transactions_model->update_voucher($transactions['id'],
				array(
					"status"   => "3",
				)
			);

			$this->session->set_flashdata('message', lang('admin security v-block'));
			redirect($this->_redirect_url);
			
		} else {
			
			redirect($this->_redirect_url);
			
		}
		
	}
	
  
     /**
     * Transactions
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
			
		if ($this->input->get('id'))
        {
						$id_xss = $this->security->xss_clean($this->input->get('id'));
						$id_string = str_replace(' ', '-', $id_xss);
						$id_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $id_string);
            $filters['id'] = $id_replace;
        }

        if ($this->input->get('type'))
        {
						$type_xss = $this->security->xss_clean($this->input->get('type'));
						$type_string = str_replace(' ', '-', $type_xss);
						$type_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $type_string);
            $filters['type'] = $type_replace;
        }
      
        if ($this->input->get('ip_address'))
        {
						$ip_address_xss = $this->security->xss_clean($this->input->get('ip_address'));
						$ip_address_replace = htmlentities($ip_address_xss, ENT_QUOTES, "UTF-8");
            $filters['ip_address'] = $ip_address_replace;
        }
      
        if ($this->input->get('user_comment'))
        {
						$user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
						$user_comment_replace = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['user_comment'] = $user_comment_replace;
        }
      
        if ($this->input->get('admin_comment'))
        {
						$admin_comment_xss = $this->security->xss_clean($this->input->get('admin_comment'));
						$admin_comment_replace = htmlentities($admin_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['admin_comment'] = $admin_comment_replace;
        }

        if ($this->input->get('status'))
        {
						$status_xss = $this->security->xss_clean($this->input->get('status'));
						$status_string = str_replace(' ', '-', $status_xss);
						$status_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $status_string);
            $filters['status'] = $status_replace;
        }
			
		if ($this->input->get('sender'))
        {
						$sender_xss = $this->security->xss_clean($this->input->get('sender'));
						$sender_string = str_replace(' ', '-', $sender_xss);
						$sender_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $sender_string);
            $filters['sender'] = $sender_replace;
        }
			
		if ($this->input->get('receiver'))
        {
						$receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
						$receiver_string = str_replace(' ', '-', $receiver_xss);
						$receiver_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $receiver_string);
            $filters['receiver'] = $receiver_replace;
        }
			
		if ($this->input->get('time'))
        {
						$time_xss = $this->security->xss_clean($this->input->get('time'));
						$time_string = str_replace(' ', '-', $time_xss);
						$time_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $time_string);
            $filters['time'] = $time_replace;
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

                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
              
                if ($this->input->post('ip_address'))
                {
                    $filter .= "&ip_address=" . $this->input->post('ip_address', TRUE);
                }
              
                if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
              
                if ($this->input->post('admin_comment'))
                {
                    $filter .= "&admin_comment=" . $this->input->post('admin_comment', TRUE);
                }

                if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }
							
				if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
				if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
				if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_all($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_all($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/index', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
     /**
     * Transactions pending
     */
    function pending()
    {
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

        if ($this->input->get('type'))
        {
						$type_xss = $this->security->xss_clean($this->input->get('type'));
						$type_string = str_replace(' ', '-', $type_xss);
						$type_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $type_string);
            $filters['type'] = $type_replace;
        }
      
        if ($this->input->get('ip_address'))
        {
						$ip_address_xss = $this->security->xss_clean($this->input->get('ip_address'));
						$ip_address_replace = htmlentities($ip_address_xss, ENT_QUOTES, "UTF-8");
            $filters['ip_address'] = $ip_address_replace;
        }
      
        if ($this->input->get('user_comment'))
        {
						$user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
						$user_comment_replace = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['user_comment'] = $user_comment_replace;
        }
      
        if ($this->input->get('admin_comment'))
        {
						$admin_comment_xss = $this->security->xss_clean($this->input->get('admin_comment'));
						$admin_comment_replace = htmlentities($admin_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['admin_comment'] = $admin_comment_replace;
        }
			
		if ($this->input->get('sender'))
        {
						$sender_xss = $this->security->xss_clean($this->input->get('sender'));
						$sender_string = str_replace(' ', '-', $sender_xss);
						$sender_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $sender_string);
            $filters['sender'] = $sender_replace;
        }
			
		if ($this->input->get('receiver'))
        {
						$receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
						$receiver_string = str_replace(' ', '-', $receiver_xss);
						$receiver_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $receiver_string);
            $filters['receiver'] = $receiver_replace;
        }
			
		if ($this->input->get('time'))
        {
						$time_xss = $this->security->xss_clean($this->input->get('time'));
						$time_string = str_replace(' ', '-', $time_xss);
						$time_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $time_string);
            $filters['time'] = $time_replace;
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
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
              
                if ($this->input->post('ip_address'))
                {
                    $filter .= "&ip_address=" . $this->input->post('ip_address', TRUE);
                }
              
                if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
              
                if ($this->input->post('admin_comment'))
                {
                    $filter .= "&admin_comment=" . $this->input->post('admin_comment', TRUE);
                }

							
				if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
				if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
				if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_pending($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_pending($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL_2,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/pending', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
         /**
     * Transactions confirmed
     */
    function confirmed()
    {
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

        if ($this->input->get('type'))
        {
						$type_xss = $this->security->xss_clean($this->input->get('type'));
						$type_string = str_replace(' ', '-', $type_xss);
						$type_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $type_string);
            $filters['type'] = $type_replace;
        }
      
        if ($this->input->get('ip_address'))
        {
						$ip_address_xss = $this->security->xss_clean($this->input->get('ip_address'));
						$ip_address_replace = htmlentities($ip_address_xss, ENT_QUOTES, "UTF-8");
            $filters['ip_address'] = $ip_address_replace;
        }
      
        if ($this->input->get('user_comment'))
        {
						$user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
						$user_comment_replace = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['user_comment'] = $user_comment_replace;
        }
      
        if ($this->input->get('admin_comment'))
        {
						$admin_comment_xss = $this->security->xss_clean($this->input->get('admin_comment'));
						$admin_comment_replace = htmlentities($admin_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['admin_comment'] = $admin_comment_replace;
        }
			
		if ($this->input->get('sender'))
        {
						$sender_xss = $this->security->xss_clean($this->input->get('sender'));
						$sender_string = str_replace(' ', '-', $sender_xss);
						$sender_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $sender_string);
            $filters['sender'] = $sender_replace;
        }
			
		if ($this->input->get('receiver'))
        {
						$receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
						$receiver_string = str_replace(' ', '-', $receiver_xss);
						$receiver_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $receiver_string);
            $filters['receiver'] = $receiver_replace;
        }
			
		if ($this->input->get('time'))
        {
						$time_xss = $this->security->xss_clean($this->input->get('time'));
						$time_string = str_replace(' ', '-', $time_xss);
						$time_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $time_string);
            $filters['time'] = $time_replace;
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
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
              
                if ($this->input->post('ip_address'))
                {
                    $filter .= "&ip_address=" . $this->input->post('ip_address', TRUE);
                }
              
                if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
              
                if ($this->input->post('admin_comment'))
                {
                    $filter .= "&admin_comment=" . $this->input->post('admin_comment', TRUE);
                }

							
				if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
				if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
				if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_confirmed($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_confirmed($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL_3,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/confirmed', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
  
           /**
     * Transactions disputed
     */
    function disputed()
    {
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

        if ($this->input->get('type'))
        {
						$type_xss = $this->security->xss_clean($this->input->get('type'));
						$type_string = str_replace(' ', '-', $type_xss);
						$type_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $type_string);
            $filters['type'] = $type_replace;
        }
      
        if ($this->input->get('ip_address'))
        {
						$ip_address_xss = $this->security->xss_clean($this->input->get('ip_address'));
						$ip_address_replace = htmlentities($ip_address_xss, ENT_QUOTES, "UTF-8");
            $filters['ip_address'] = $ip_address_replace;
        }
      
        if ($this->input->get('user_comment'))
        {
						$user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
						$user_comment_replace = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['user_comment'] = $user_comment_replace;
        }
      
        if ($this->input->get('admin_comment'))
        {
						$admin_comment_xss = $this->security->xss_clean($this->input->get('admin_comment'));
						$admin_comment_replace = htmlentities($admin_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['admin_comment'] = $admin_comment_replace;
        }
			
		if ($this->input->get('sender'))
        {
						$sender_xss = $this->security->xss_clean($this->input->get('sender'));
						$sender_string = str_replace(' ', '-', $sender_xss);
						$sender_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $sender_string);
            $filters['sender'] = $sender_replace;
        }
			
		if ($this->input->get('receiver'))
        {
						$receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
						$receiver_string = str_replace(' ', '-', $receiver_xss);
						$receiver_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $receiver_string);
            $filters['receiver'] = $receiver_replace;
        }
			
		if ($this->input->get('time'))
        {
						$time_xss = $this->security->xss_clean($this->input->get('time'));
						$time_string = str_replace(' ', '-', $time_xss);
						$time_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $time_string);
            $filters['time'] = $time_replace;
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
                redirect(THIS_URL_4);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
              
                if ($this->input->post('ip_address'))
                {
                    $filter .= "&ip_address=" . $this->input->post('ip_address', TRUE);
                }
              
                if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
              
                if ($this->input->post('admin_comment'))
                {
                    $filter .= "&admin_comment=" . $this->input->post('admin_comment', TRUE);
                }

							
				if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
				if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
				if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_disputed($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_disputed($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL_4,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/disputed', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
             /**
     * Transactions blocked
     */
    function blocked()
    {
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

        if ($this->input->get('type'))
        {
						$type_xss = $this->security->xss_clean($this->input->get('type'));
						$type_string = str_replace(' ', '-', $type_xss);
						$type_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $type_string);
            $filters['type'] = $type_replace;
        }
      
        if ($this->input->get('ip_address'))
        {
						$ip_address_xss = $this->security->xss_clean($this->input->get('ip_address'));
						$ip_address_replace = htmlentities($ip_address_xss, ENT_QUOTES, "UTF-8");
            $filters['ip_address'] = $ip_address_replace;
        }
      
        if ($this->input->get('user_comment'))
        {
						$user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
						$user_comment_replace = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['user_comment'] = $user_comment_replace;
        }
      
        if ($this->input->get('admin_comment'))
        {
						$admin_comment_xss = $this->security->xss_clean($this->input->get('admin_comment'));
						$admin_comment_replace = htmlentities($admin_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['admin_comment'] = $admin_comment_replace;
        }
			
		if ($this->input->get('sender'))
        {
						$sender_xss = $this->security->xss_clean($this->input->get('sender'));
						$sender_string = str_replace(' ', '-', $sender_xss);
						$sender_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $sender_string);
            $filters['sender'] = $sender_replace;
        }
			
		if ($this->input->get('receiver'))
        {
						$receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
						$receiver_string = str_replace(' ', '-', $receiver_xss);
						$receiver_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $receiver_string);
            $filters['receiver'] = $receiver_replace;
        }
			
		if ($this->input->get('time'))
        {
						$time_xss = $this->security->xss_clean($this->input->get('time'));
						$time_string = str_replace(' ', '-', $time_xss);
						$time_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $time_string);
            $filters['time'] = $time_replace;
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
                redirect(THIS_URL_5);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
              
                if ($this->input->post('ip_address'))
                {
                    $filter .= "&ip_address=" . $this->input->post('ip_address', TRUE);
                }
              
                if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
              
                if ($this->input->post('admin_comment'))
                {
                    $filter .= "&admin_comment=" . $this->input->post('admin_comment', TRUE);
                }

							
				if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
				if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
				if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_blocked($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_blocked($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL_5,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/blocked', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
               /**
     * Transactions refunded
     */
    function refunded()
    {
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

        if ($this->input->get('type'))
        {
						$type_xss = $this->security->xss_clean($this->input->get('type'));
						$type_string = str_replace(' ', '-', $type_xss);
						$type_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $type_string);
            $filters['type'] = $type_replace;
        }
      
        if ($this->input->get('ip_address'))
        {
						$ip_address_xss = $this->security->xss_clean($this->input->get('ip_address'));
						$ip_address_replace = htmlentities($ip_address_xss, ENT_QUOTES, "UTF-8");
            $filters['ip_address'] = $ip_address_replace;
        }
      
        if ($this->input->get('user_comment'))
        {
						$user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
						$user_comment_replace = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['user_comment'] = $user_comment_replace;
        }
      
        if ($this->input->get('admin_comment'))
        {
						$admin_comment_xss = $this->security->xss_clean($this->input->get('admin_comment'));
						$admin_comment_replace = htmlentities($admin_comment_xss, ENT_QUOTES, "UTF-8");
            $filters['admin_comment'] = $admin_comment_replace;
        }
			
		if ($this->input->get('sender'))
        {
						$sender_xss = $this->security->xss_clean($this->input->get('sender'));
						$sender_string = str_replace(' ', '-', $sender_xss);
						$sender_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $sender_string);
            $filters['sender'] = $sender_replace;
        }
			
		if ($this->input->get('receiver'))
        {
						$receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
						$receiver_string = str_replace(' ', '-', $receiver_xss);
						$receiver_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $receiver_string);
            $filters['receiver'] = $receiver_replace;
        }
			
		if ($this->input->get('time'))
        {
						$time_xss = $this->security->xss_clean($this->input->get('time'));
						$time_string = str_replace(' ', '-', $time_xss);
						$time_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $time_string);
            $filters['time'] = $time_replace;
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
                redirect(THIS_URL_6);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
              
                if ($this->input->post('ip_address'))
                {
                    $filter .= "&ip_address=" . $this->input->post('ip_address', TRUE);
                }
              
                if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
              
                if ($this->input->post('admin_comment'))
                {
                    $filter .= "&admin_comment=" . $this->input->post('admin_comment', TRUE);
                }

							
				if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
				if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
				if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_6 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$transactions = $this->transactions_model->get_refunded($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_6 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title transactions') );
		
        $data = $this->includes;
			
		// get list
		$transactions = $this->transactions_model->get_refunded($limit, $offset, $filters, $sort, $dir);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $transactions['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'      => THIS_URL_6,
            'transactions'  => $transactions['results'],
            'total'         => $transactions['total'],
            'filters'       => $filters,
            'filter'        => $filter,
            'pagination'    => $this->pagination->create_links(),
            'limit'         => $limit,
            'offset'        => $offset,
            'sort'          => $sort,
            'dir'           => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/transactions/refunded', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	function ok_deposit($id = NULL)
  {
		
		// make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_transactions($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		if ($transactions['status'] == 1 && $transactions['type'] == 1) {
			
			$user = $this->users_model->get_username($transactions['receiver']);
			
			$wallet = $transactions['currency'];
			$amount = $transactions['amount'];
			
			// Calculation of the amount to be credited to the claimant 
			$return = $user[$wallet]+$amount;
			
			// update claimant wallet
			$this->users_model->update_user($transactions['receiver'],
				array(
					$transactions['currency']  => $return,
				)
			);
			
			// update transaction history
			$this->transactions_model->update_btc_transactions($transactions['id'],
				array(
					"status"   => "2",
				)
			);
			
			$this->session->set_flashdata('message', lang('admin profit 17'));
			redirect($this->_redirect_url);
			
		} else {
			
			redirect($this->_redirect_url);
			
		}
		
	}

	function ok_withdrawal($id = NULL)
  {
		
     // make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_transactions($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		if ($transactions['status'] == 1 && $transactions['type'] == 2) {
			
			$user = $this->users_model->get_username($transactions['sender']);
			
			// update transaction history
			$this->transactions_model->update_btc_transactions($transactions['id'],
				array(
					"status"   => "2",
				)
			);
			
			$email_template = $this->template_model->get_email_template(26);
			
			if($email_template['status'] == "1") {
				
						$currency = $transactions['currency'];
						
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

						$vals_1 = array($site_name, $link, $name_user, $transactions['amount'], $symbol);

						//replace
						$str_1 = str_replace($placeholders, $vals_1, $rawstring);

						$this -> email -> from($this->settings->site_email, $this->settings->site_name);
						$this->email->to($user['email']);
						//$this -> email -> to($user['email']);
						$this -> email -> subject($email_template['title']);

						$this -> email -> message($str_1);

						$this->email->send();

					}
			
					$sms_template = $this->template_model->get_sms_template(16);
							
									if($sms_template['status'] == "1") {
										
										$currency = $transactions['currency'];
						
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

										$vals_1 = array($transactions['amount'], $symbol);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}

			$this->session->set_flashdata('message', lang('admin profit 17'));
			redirect($this->_redirect_url);
			
		} else {
			
			redirect($this->_redirect_url);
			
		}
		
	}
	
	function no_withdrawal($id = NULL)
  {
		
     // make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_transactions($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		if ($transactions['status'] == 1 && $transactions['type'] == 2) {
			
			$user = $this->users_model->get_username($transactions['sender']);
			
			$sender = $this->users_model->get_username($transactions['sender']);
			$wallet = $transactions['currency'];
			$amount = $transactions['sum'];

			// Calculation of the amount to be sender
			$return = $sender[$wallet]+$amount;

			// update sender wallet
			$this->users_model->update_user($transactions['sender'],
				array(
					$transactions['currency']  => $return,
				)
			);
			
			// update transaction history
			$this->transactions_model->update_btc_transactions($transactions['id'],
				array(
					"status"   => "3",
				)
			);
			
			$email_template = $this->template_model->get_email_template(27);
			
			if($email_template['status'] == "1") {
				
						$currency = $transactions['currency'];
						
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

						$vals_1 = array($site_name, $link, $name_user, $transactions['sum'], $symbol);

						//replace
						$str_1 = str_replace($placeholders, $vals_1, $rawstring);

						$this -> email -> from($this->settings->site_email, $this->settings->site_name);
						$this->email->to($user['email']);
						//$this -> email -> to($user['email']);
						$this -> email -> subject($email_template['title']);

						$this -> email -> message($str_1);

						$this->email->send();

					}
			
			$sms_template = $this->template_model->get_sms_template(17);
							
									if($sms_template['status'] == "1") {
										
										$currency = $transactions['currency'];
						
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

										$vals_1 = array($transactions['amount'], $symbol);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}

			$this->session->set_flashdata('message', lang('admin profit 18'));
			redirect($this->_redirect_url);
			
		} else {
			
			redirect($this->_redirect_url);
			
		}
		
	}
	
	 /**
     * Hold
     */
	function on_hold($id = NULL)
  {
		
     // make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_transactions($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		if ($transactions['status'] != 5) {
			
			// update transaction history
			$this->transactions_model->update_btc_transactions($transactions['id'],
				array(
					"status"   => "5",
				)
			);

			$this->session->set_flashdata('message', lang('admin security on-hold-success'));
			redirect($this->_redirect_url);
			
		} else {
			
			redirect($this->_redirect_url);
			
		}
		
	}
	
	/**
     * Hold
     */
	function re_hold($id = NULL)
  {
		
     // make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_transactions($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		if ($transactions['status'] == 5) {
			
			// update transaction history
			$this->transactions_model->update_btc_transactions($transactions['id'],
				array(
					"status"   => "2",
				)
			);
			
			$this->session->set_flashdata('message', lang('admin security re-hold-success'));
    	redirect($this->_redirect_url);
			
		} else {
			
    	redirect($this->_redirect_url);
			
		}
		
	}
	
	/**
     * Hold
     */
	function refund($id = NULL)
  {
		
     // make sure we have a numeric id
     if (is_null($id) OR ! is_numeric($id))
     {
     	redirect($this->_redirect_url);
     }

     // get the data
     $transactions = $this->transactions_model->get_transactions($id);

     // if empty results, return to list
     if ( ! $transactions)
     {
     	redirect($this->_redirect_url);
     }
		
		$sender = $this->users_model->get_username($transactions['sender']);
		$receiver = $this->users_model->get_username($transactions['receiver']);
		$wallet = $transactions['currency'];
		$amount = $transactions['amount'];
		
		if ($transactions['status'] != 3) {
			
			// Calculation of the amount to debit the receiver account
			$refund = $receiver[$wallet]-$amount;

			// Calculation of the amount to be sender
			$return = $sender[$wallet]+$amount;
			
			// update receiver and wallet
			$this->users_model->update_user($transactions['receiver'],
				array(
					$transactions['currency']  => $refund,
				)
			);

			// update sender wallet
			$this->users_model->update_user($transactions['sender'],
				array(
					$transactions['currency']  => $return,
				)
			);
			
			// update transaction history
			$this->transactions_model->update_btc_transactions($transactions['id'],
				array(
					"status"   => "3",
				)
			);
			
			$this->session->set_flashdata('message', lang('admin security refund-success'));
    	redirect($this->_redirect_url);
			
		} else {
			
    	redirect($this->_redirect_url);
			
		}
		
	}
  
  /**
     * Edit transaction
     */
	function edit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $transactions = $this->transactions_model->get_transactions($id);

        // if empty results, return to list
        if ( ! $transactions)
        {
            redirect($this->_redirect_url);
        }

		$this->form_validation->set_rules('sender', lang('admins trans sender'), 'required');
		$this->form_validation->set_rules('receiver', lang('admins trans receiver'), 'required');
    $this->form_validation->set_rules('ip_address', lang('admin events ip'), 'required');
    $this->form_validation->set_rules('label', lang('admin new label_transaction'), 'required|max_length[100]');
    $this->form_validation->set_rules('protect', lang('admin new code_ptotection'), 'required|max_length[4]|min_length[4]');
		$this->form_validation->set_rules('user_comment', lang('admins trans comment'), 'max_length[100]');
		$this->form_validation->set_rules('admin_comment', lang('admins trans admins_comment'), 'max_length[300]');
				

        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->transactions_model->edit_transaction($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('users msg edit_user_success'));
            }
            else
            {
				$this->session->set_flashdata('error', lang('users error edit_user_failed'));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }
		
				if ($transactions['type'] == 5) {
					
					$merchant = $this->merchants_model->get_user_merchant($transactions['merchant'], $transactions['receiver']);
					
				} else {
					
					$merchant = "none";
					
				}

        // setup page header data
        $this->set_title( lang('admins title transactions') );

        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'transactions'      => $transactions,
            'transactions_id'   => $id,
						'merchant'   => $merchant
        );

        // load views
        $data['content'] = $this->load->view('admin/transactions/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }	
  
}