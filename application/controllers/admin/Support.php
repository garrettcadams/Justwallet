<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends Admin_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
			
			  $this->load->helper('security');
		    // load the logs model
        $this->load->model('support_model');
				$this->load->model('users_model');
				$this->load->model('template_model');
				$this->load->model('verification_model');
        $this->load->library('notice');
				
		    // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/support'));
        define('THIS_URL_2', base_url('admin/support/untreated'));
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
     * All tickets
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
						$id_replace = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_replace;
        }
			
		if ($this->input->get('date'))
        {
            $date_xss = $this->security->xss_clean($this->input->get('date'));
						$date_replace = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
            $filters['date'] = $date_replace;
        }

        if ($this->input->get('user'))
        {
            $user_xss = $this->security->xss_clean($this->input->get('user'));
						$user_replace = htmlentities($user_xss, ENT_QUOTES, "UTF-8");
            $filters['user'] = $user_replace;
        }
        if ($this->input->get('code'))
        {
            $code_xss = $this->security->xss_clean($this->input->get('code'));
						$code_replace = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
            $filters['code'] = $code_replace;
        }
				if ($this->input->get('title'))
        {
            $title_xss = $this->security->xss_clean($this->input->get('title'));
						$title_replace = htmlentities($title_xss, ENT_QUOTES, "UTF-8");
            $filters['title'] = $title_replace;
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
							
				if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }

                if ($this->input->post('user'))
                {
                    $filter .= "&user=" . $this->input->post('user', TRUE);
                }
              
                if ($this->input->post('code'))
                {
                    $filter .= "&code=" . $this->input->post('code', TRUE);
                }
								if ($this->input->post('title'))
                {
                    $filter .= "&title=" . $this->input->post('title', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$tickets = $this->support_model->get_all($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->set_title( lang('admin tickets menu') );
			
		$data = $this->includes;
      
		
        // get list
		$tickets = $this->support_model->get_all($limit, $offset, $filters, $sort, $dir);
      
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $tickets['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'sum_tickets'   => $sum_tickets,
            'this_url'   => THIS_URL,
            'tickets'    => $tickets['results'],
            'total'      => $tickets['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/support/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
  /**
     * Untreated tickets
     */
    function untreated()
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
						$id_replace = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_replace;
        }
			
		if ($this->input->get('date'))
        {
            $date_xss = $this->security->xss_clean($this->input->get('date'));
						$date_replace = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
            $filters['date'] = $date_replace;
        }

        if ($this->input->get('user'))
        {
            $user_xss = $this->security->xss_clean($this->input->get('user'));
						$user_replace = htmlentities($user_xss, ENT_QUOTES, "UTF-8");
            $filters['user'] = $user_replace;
        }
        if ($this->input->get('code'))
        {
            $code_xss = $this->security->xss_clean($this->input->get('code'));
						$code_replace = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
            $filters['code'] = $code_replace;
        }
				if ($this->input->get('title'))
        {
            $title_xss = $this->security->xss_clean($this->input->get('title'));
						$title_replace = htmlentities($title_xss, ENT_QUOTES, "UTF-8");
            $filters['title'] = $title_replace;
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
							
				if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }

                if ($this->input->post('user'))
                {
                    $filter .= "&user=" . $this->input->post('user', TRUE);
                }
              
                if ($this->input->post('code'))
                {
                    $filter .= "&code=" . $this->input->post('code', TRUE);
                }
							
								if ($this->input->post('title'))
                {
                    $filter .= "&title=" . $this->input->post('title', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$tickets = $this->support_model->get_untreated($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->set_title( lang('admin tickets menu') );
			
		$data = $this->includes;
		
        // get list
		$tickets = $this->support_model->get_untreated($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $tickets['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_2,
            'tickets'    => $tickets['results'],
            'total'      => $tickets['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/support/untreated', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
		/**
     * Edit tickets
     */
	
	function edit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $tickets = $this->support_model->get_tickets($id);

        // if empty results, return to list
        if ( ! $tickets)
        {
            redirect($this->_redirect_url);
        }

			$this->form_validation->set_rules('date', lang('admin tickets date'), 'required');
			$this->form_validation->set_rules('user', lang('admin tickets user'), 'required');
			$this->form_validation->set_rules('status', lang('admin col status'), 'required');
			
			$log_comment = $this->support_model->get_log_comment($tickets['id']);

            if ($this->form_validation->run() == TRUE)
            {
                // save the changes
                $saved = $this->support_model->edit_tickets($this->input->post());

                if ($saved)
                {
                    $this->session->set_flashdata('message', lang('admin tickets success_edit'));
                }
                else
                {
    				$this->session->set_flashdata('error', lang('users error edit_user_failed'));
                }

                // return to list and display message
                redirect($this->_redirect_url);
            }

        // setup page header data
        $this->set_title( lang('admin tickets detail') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   	=> THIS_URL,
            'cancel_url'    => $this->_redirect_url,
            'tickets'       => $tickets,
			'log_comment'   => $log_comment,
            'ticket_id'     => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/support/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
		/**
     * Add admin comment
     */
	function add_admin_comment($id)
	{
		// get the data
    $tickets = $this->support_model->get_tickets($id);
		$user = $this->users_model->get_username($tickets['user']);
		
		$this->form_validation->set_rules('comment', lang('admin tickets enter'), 'required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$comment = $this->security->xss_clean($this->input->post("comment"));
			if ($tickets['status'] != "2") {
				$comments = $this->support_model->add_admin_comment(array(
					"id_ticket" 	=> $tickets['id'],
					"date"          => date('Y-m-d H:i:s'),
					"user"          => $this->settings->site_name,
					"role"          => "0",
					"comment"       => $comment,
					)
				 );
				
				$email_template = $this->template_model->get_email_template(5);
				
				if($email_template['status'] == "1") {
							
							
								// variables to replace
								$site_name = $this->settings->site_name;
								$link = site_url('account/support/detail_ticket');
								$ticket_link = ''.$link.'/'.$tickets['code'];
								$name_user = $user['first_name'] . ' ' . $user['last_name'];

								$rawstring = $email_template['message'];

								// what will we replace
								$placeholders = array('[SITE_NAME]','[CODE_TICKET]', '[TICKET_LINK]', '[NAME]');

								$vals_1 = array($site_name, $tickets['code'], $ticket_link, $name_user);

								//replace
								$str_1 = str_replace($placeholders, $vals_1, $rawstring);

								$this -> email -> from($this->settings->site_email, $this->settings->site_name);
								$this->email->to($user['email']);
								//$this -> email -> to($user['email']);
								$this -> email -> subject($email_template['title']);

								$this -> email -> message($str_1);

								$this->email->send();
							
							}
				
									$sms_template = $this->template_model->get_sms_template(4);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[CODE_TICKET]');

										$vals_1 = array($tickets['code']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}
				
			} else {
				$this->session->set_flashdata('error', lang('admin tickets error_close'));
				redirect(site_url("admin/support"));
			}
			
		} else {
			$this->session->set_flashdata('error', lang('admin tickets error_message'));
			redirect(site_url("admin/support"));
		}
			
		// update ticket status
		$this->support_model->update_ticket($id,
			array(
				"status"   => "1",
				)
			);
			
		$this->session->set_flashdata('message', lang('admin tickets admin_comment'));
		redirect(site_url("admin/support"));

	}
	
	/**
     * Close ticket
     */
	function close_ticket($id)
	{
		// get the data
    $tickets = $this->support_model->get_tickets($id);
		$user = $this->users_model->get_username($tickets['user']);
		if ($tickets['status'] != "2") {
			// update ticket status
			$this->support_model->update_ticket($id,
				array(
					"status"   => "2",
					)
				);
			$email_template = $this->template_model->get_email_template(6);
				
				if($email_template['status'] == "1") {
	
								// variables to replace
								$site_name = $this->settings->site_name;
								$link = site_url('account/support/detail_ticket');
								$ticket_link = ''.$link.'/'.$tickets['code'];
								$name_user = $user['first_name'] . ' ' . $user['last_name'];

								$rawstring = $email_template['message'];

								// what will we replace
								$placeholders = array('[SITE_NAME]','[CODE_TICKET]', '[TICKET_LINK]', '[NAME]');

								$vals_1 = array($site_name, $tickets['code'], $ticket_link, $name_user);

								//replace
								$str_1 = str_replace($placeholders, $vals_1, $rawstring);

								$this -> email -> from($this->settings->site_email, $this->settings->site_name);
								$this->email->to($user['email']);
								//$this -> email -> to($user['email']);
								$this -> email -> subject($email_template['title']);

								$this -> email -> message($str_1);

								$this->email->send();
							
							}
			
									$sms_template = $this->template_model->get_sms_template(5);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[CODE_TICKET]');

										$vals_1 = array($tickets['code']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user['phone'], $str_1);
										
									}
		} else {
			$this->session->set_flashdata('error', lang('admin tickets error_close'));
			redirect(site_url("admin/support"));
		}

		$this->session->set_flashdata('message', lang('admin tickets success_close'));
		redirect(site_url("admin/support"));

	}
	
	/**
     * Openticket
     */
	function open_ticket($id)
	{
		// get the data
    $tickets = $this->support_model->get_tickets($id);
		$user = $this->users_model->get_username($tickets['user']);
		if ($tickets['status'] == "2") {
			// update ticket status
			$this->support_model->update_ticket($id,
				array(
					"status"   => "0",
					)
				);
		} else {
			$this->session->set_flashdata('error', lang('admin tickets error_open'));
			redirect(site_url("admin/support"));
		}

		$this->session->set_flashdata('message', lang('admin tickets success_open'));
		redirect(site_url("admin/support"));

	}
	
	/**
     * Add tickets page
     */
	function new_ticket()
	{	
		// setup page header data
		$this
			->add_js_theme( "dashboard_i18n.js", TRUE )
			->set_title( lang('admin tickets new_ticket') );
		
       $data = $this->includes;

       // load views
       $data['content'] = $this->load->view('admin/support/new_ticket', NULL, TRUE);
       $this->load->view($this->template, $data);

	}
	
	/**
     * Add tickets form
     */
	function add_ticket()
	{
		$this->form_validation->set_rules('username', lang('admin tickets user'), 'required|trim|callback__check_username[]');
		$this->form_validation->set_rules('title', lang('admin tickets title'), 'required');
		$this->form_validation->set_rules('message', lang('admin tickets message'), 'required');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', lang('admin tickets form_fail'));
			redirect(site_url("admin/support/new_ticket"));
		}
		else
		{
			$username = $this->security->xss_clean($this->input->post("username"));
			$title = $this->security->xss_clean($this->input->post("title"));
			$message = $this->security->xss_clean($this->input->post("message"));
			$code = uniqid("tic_");
			
			// get the data
      $user = $this->users_model->get_username($username);

			$ticket = $this->support_model->add_ticket(array(
				"date"   => date('Y-m-d H:i:s'),
				"user"   => $username,
				"title"  => $title,
				"status" => "1",
				"code"    => $code,
				)
			);
			
			$comment_id = $this->support_model->get_id_comment($code);
			
			$comments = $this->support_model->add_admin_comment(array(
					"id_ticket" 	  => $comment_id['id'],
					"date"          => date('Y-m-d H:i:s'),
					"user"          => $this->settings->site_name,
					"role"          => "0",
					"comment"       => $message,
					)
				 );
			
			$email_template = $this->template_model->get_email_template(4);
			
			if($email_template['status'] == "1") {
							
								// variables to replace
								$site_name = $this->settings->site_name;
								$link = site_url('account/support/detail_ticket');
								$ticket_link = ''.$link.'/'.$code;
								$name_user = $user['first_name'] . ' ' . $user['last_name'];

								$rawstring = $email_template['message'];

								// what will we replace
								$placeholders = array('[SITE_NAME]','[CODE_TICKET]', '[TICKET_LINK]', '[NAME]');

								$vals_1 = array($site_name, $code, $ticket_link, $name_user);

								//replace
								$str_1 = str_replace($placeholders, $vals_1, $rawstring);

								$this -> email -> from($this->settings->site_email, $this->settings->site_name);
								$this->email->to($user['email']);
								//$this -> email -> to($user['email']);
								$this -> email -> subject($email_template['title']);

								$this -> email -> message($str_1);

								$this->email->send();
							
							}
			
									$sms_template = $this->template_model->get_sms_template(3);
							
									if($sms_template['status'] == "1") {

										$result = $this->sms->send_sms($user['phone'], $sms_template['message']);
										
									}

			$this->session->set_flashdata('message', lang('admin tickets success_create'));
			redirect(site_url('admin/support'));
		}

	}
	
	/**
     * Check true username new ticket
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