<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Support extends Private_Controller {

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
        $this->load->model('support_model');
		$this->load->model('events_model');
		$this->load->model('template_model');
      
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/support'));
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
		
		$username = $user['username'];
		
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
					
			$ticket = $this->support_model->get_list_tickets($limit, $offset, $filters, $sort, $dir, $username);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users support title_1'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$ticket = $this->support_model->get_list_tickets($limit, $offset, $filters, $sort, $dir, $username);
		
		$user = $this->users_model->get_user($this->user['id']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $ticket['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL,
            'ticket'     => $ticket['results'],
            'total'    	 => $ticket['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/support/support', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
  
  	/**
    * Detail ticket
    */
	function detail_ticket($code = NULL)
    {

		$user = $this->users_model->get_user($this->user['id']);
			   
        // make sure we have a numeric id
        if (is_null($code))
        {
            redirect(THIS_URL);
        }

        // get the data
        $ticket = $this->support_model->get_detail_ticket($code, $user['username']);
    
		$log_comment = $this->support_model->get_log_comment($ticket['id']);

        // if empty results, return to list
        if ( ! $ticket)
        {
            redirect(THIS_URL);
        }

        // setup page header data
        $this->set_title( lang('users tickets detail') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   		=> THIS_URL,
			'user'              => $user,
            'cancel_url'        => THIS_URL,
            'ticket'      		=> $ticket,
			'log_comment'      	=> $log_comment,
            'ticket_id'   		=> $code
        );

        // load views
        $data['content'] = $this->load->view('account/support/detail_ticket', $content_data, TRUE);
        $this->load->view($this->template, $data);

    }
	
	/**
    * Add user comment
    */
	function add_user_comment($code)
	{
		// get the data
		$user = $this->users_model->get_user($this->user['id']);
    	$ticket = $this->support_model->get_detail_ticket($code, $user['username']);
		
		$this->form_validation->set_rules('comment', lang('admin tickets enter'), 'required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$comment = $this->security->xss_clean($this->input->post("comment", TRUE));
			
			if ($ticket['status'] != "2" && $ticket['user'] == $user['username']) {

				$comments = $this->support_model->add_admin_comment(array(
					"id_ticket" 	=> $ticket['id'],
					"date"          => date('Y-m-d H:i:s'),
					"user"          => $user['username'],
					"role"          => "1",
					"comment"       => $comment,
					)
				 );
				
				// Register event
							
				$event = $this->events_model->register_event(array(
					"type" 				=> "4",
					"user"  			=> $user['username'],
					"ip"    			=> $_SERVER['REMOTE_ADDR'],
					"date" 			  	=> date('Y-m-d H:i:s'),
					"code"			  	=> uniqid("evn_"),
					)
				);

				
			} else {

				$this->session->set_flashdata('error', lang('users tickets new_error'));
				redirect(site_url("account/support"));

			}
			
		} else {

			$this->session->set_flashdata('error', lang('users tickets new_error'));
			redirect(site_url("account/support"));

		}
			
		// update ticket status
		$this->support_model->update_ticket($ticket['id'],
			array(
				"status"   => "0",
			)
		);
			
		$this->session->set_flashdata('message', lang('users tickets new_success'));
		redirect(site_url("account/support"));

	}
	
	/**
    * Close ticket
    */
	function close_ticket($code)
	{

		// get the data
    	$user = $this->users_model->get_user($this->user['id']);
    	$ticket = $this->support_model->get_detail_ticket($code, $user['username']);

		if ($ticket['status'] != "2" && $ticket['user'] == $user['username']) {

			// update ticket status
			$this->support_model->update_ticket($ticket['id'],
				array(
					"status"   => "2",
					)
				);
			
			// Register event
							
			$event = $this->events_model->register_event(array(
				"type" 				=> "5",
				"user"  			=> $user['username'],
				"ip"    			=> $_SERVER['REMOTE_ADDR'],
				"date" 			  	=> date('Y-m-d H:i:s'),
				"code"			  	=> uniqid("evn_"),
				)
			);

		} else {

			$this->session->set_flashdata('error', lang('users tickets close_error'));
			redirect(site_url("account/support"));

		}

		$this->session->set_flashdata('message', lang('ausers tickets close_success'));
		redirect(site_url("account/support"));

	}
  
  /**
    * Reopen ticket
    */
	function reopen_ticket($code)
	{

		// get the data
    	$user = $this->users_model->get_user($this->user['id']);
    	$ticket = $this->support_model->get_detail_ticket($code, $user['username']);

		if ($ticket['status'] == "2" && $ticket['user'] == $user['username']) {

			// update ticket status
			$this->support_model->update_ticket($ticket['id'],
				array(
					"status"   => "1",
					)
				);
			
			// Register event
							
			$event = $this->events_model->register_event(array(
				"type" 				=> "5",
				"user"  			=> $user['username'],
				"ip"    			=> $_SERVER['REMOTE_ADDR'],
				"date" 			  	=> date('Y-m-d H:i:s'),
				"code"			  	=> uniqid("evn_"),
				)
			);

		} else {

			$this->session->set_flashdata('error', lang('users tickets close_error'));
			redirect(site_url("account/support"));

		}

		$this->session->set_flashdata('message', lang('ausers tickets close_success'));
		redirect(site_url("account/support"));

	}
	
	/**
	* Add ticket
    */
	function new_ticket()
	{
				$user = $this->users_model->get_user($this->user['id']);

        // setup page header data
        $this->set_title(sprintf(lang('users support new_ticket'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
			'user'  => $user,	
        );

        // load views
        $data['content'] = $this->load->view('account/support/new_ticket', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	/**
    * New ticket
    */
	function add_ticket()
	{

		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('title', lang('users support title'), 'required');
		$this->form_validation->set_rules('comment', lang('users support message'), 'required');
			
		if ($this->form_validation->run() == FALSE)
		{

			$this->session->set_flashdata('error', lang('users tickets add_error'));
			redirect(site_url("account/support/new_ticket"));

		}
		else
		{

			$title = $this->security->xss_clean($this->input->post("title", TRUE));
			$comment = $this->security->xss_clean($this->input->post("comment", TRUE));
			$code = uniqid("tic_");

			$ticket = $this->support_model->add_ticket(array(
				"date"   	=> date('Y-m-d H:i:s'),
				"user"   	=> $user['username'],
				"title"  	=> $title,
				"status" 	=> "0",
				"code"   	=> $code,
				"message"   => $comment,
				)
			);
			
			// Register event
							
			$event = $this->events_model->register_event(array(
				"type" 				=> "3",
				"user"  			=> $user['username'],
				"ip"    			=> $_SERVER['REMOTE_ADDR'],
				"date" 			  	=> date('Y-m-d H:i:s'),
				"code"			  	=> uniqid("evn_"),
				)
			);

			$this->session->set_flashdata('message', lang('users tickets add_success'));
			redirect(site_url('account/support'));
		}

	}
  
}