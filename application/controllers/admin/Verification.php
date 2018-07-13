<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Verification extends Admin_Controller {
	
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
			
				// load the logs model
				$this->load->model('verification_model');
				$this->load->model('support_model');
				$this->load->model('users_model');
				$this->load->model('template_model');
				$this->load->library('notice');
			
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/verification'));
			  define('THIS_URL_2', base_url('admin/verification/untreated'));
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
     * All
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
            $filters['date'] = $date_string;
        }
			
				if ($this->input->get('code', TRUE))
        {
            $code_xss = $this->security->xss_clean($this->input->get('code'));
						$code_string = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
            $filters['code'] =$code_string;
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

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$verification = $this->verification_model->get_all($limit, $offset, $filters, $sort, $dir);
					
        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admin verify menu') );
		
        $data = $this->includes;
			
		// get list
		$verification = $this->verification_model->get_all($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $verification['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'verification'       => $verification['results'],
            'total'      => $verification['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/verification/index', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	/**
     * untreated
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
            $filters['date'] = $date_string;
        }
			
				if ($this->input->get('code', TRUE))
        {
            $code_xss = $this->security->xss_clean($this->input->get('code'));
						$code_string = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
            $filters['code'] =$code_string;
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

                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$verification = $this->verification_model->get_untreated($limit, $offset, $filters, $sort, $dir);
					
        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admin verify menu') );
		
        $data = $this->includes;
			
		// get list
		$verification = $this->verification_model->get_untreated($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $verification['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_2,
            'verification'       => $verification['results'],
            'total'      => $verification['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/verification/untreated', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	/**
     * Edit email template
     */
	function edit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $request = $this->verification_model->get_request($id);
				
        // if empty results, return to list
        if ( ! $request)
        {
            redirect($this->_redirect_url);
        }
		
				$user = $this->users_model->get_username($request['user']);

        // setup page header data
        $this->set_title( lang('admin verify detail') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   		   => THIS_URL,
						'user'      => $user,
            'cancel_url'           => $this->_redirect_url,
            'request'      => $request,
            'request_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/verification/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	function confirm_request($id)
  {
		
		// get the data
    $request = $this->verification_model->get_request($id);
		
		// if empty results, return to list
    if ( ! $request)
    {
       redirect($this->_redirect_url);
    }
		
		$user = $this->users_model->get_username($request['user']);
		
		if ($request['status'] != 1) {
			
			// update user status
			$this->users_model->update_setting_user($user['id'],
				array(
					"verify_status"   => "2",
					)
				);
			
			// update request status
			$this->verification_model->update_verification($request['code'],
				array(
					"status"   =>   "1"
					)
				);
			
			$email_template = $this->template_model->get_email_template(7);
				
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
			
			$sms_template = $this->template_model->get_sms_template(6);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										$result = $this->sms->send_sms($user['phone'], $sms_template['message']);
										
									}
			
			$this->session->set_flashdata('message', lang('users settings id_doc_success'));
			redirect(site_url("admin/verification"));
			
		} else {
			
			$this->session->set_flashdata('error', lang('admin verify error'));
			redirect(site_url("admin/verification"));
			
		}
		
	}
	
	function reject_request($id)
  {
		// get the data
    $request = $this->verification_model->get_request($id);
		
		// if empty results, return to list
    if ( ! $request)
    {
       redirect($this->_redirect_url);
    }
		
		$user = $this->users_model->get_username($request['user']);
		
		$this->form_validation->set_rules('comment', lang('admin settings comment'), 'required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$comment = $this->security->xss_clean($this->input->post("comment"));
		
			if ($request['status'] != 2) {

				// update request status
				$this->verification_model->update_verification($request['code'],
					array(
						"status"    =>   "2",
						"comment"   =>   $comment
						)
					);
				
				$email_template = $this->template_model->get_email_template(8);
				
				if($email_template['status'] == "1") {

					// variables to replace
					$site_name = $this->settings->site_name;
					$link = site_url('account/settings/verification');
					$name_user = $user['first_name'] . ' ' . $user['last_name'];
					
					$rawstring = $email_template['message'];

					// what will we replace
					$placeholders = array('[SITE_NAME]','[SITE_LINK]','[COMMENT]','[NAME]');

					$vals_1 = array($site_name, $link, $comment, $name_user);

					//replace
					$str_1 = str_replace($placeholders, $vals_1, $rawstring);

					$this -> email -> from($this->settings->site_email, $this->settings->site_name);
					$this->email->to($user['email']);
					//$this -> email -> to($user['email']);
					$this -> email -> subject($email_template['title']);

					$this -> email -> message($str_1);

					$this->email->send();

				}
				
				$sms_template = $this->template_model->get_sms_template(7);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										$result = $this->sms->send_sms($user['phone'], $sms_template['message']);
										
									}

			} else {

				$this->session->set_flashdata('error', lang('admin verify error'));
				redirect(site_url("admin/verification"));

			}
			
			$this->session->set_flashdata('message', lang('users settings id_doc_success'));
			redirect(site_url("admin/verification"));
			
		} else {
			
			$this->session->set_flashdata('error', lang('admin verify error'));
			redirect(site_url("admin/verification"));
			
		}
		
	}
	
	function delete($id)
  {
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
     	redirect($this->_redirect_url);
    }

	  $del = $this->verification_model->delete_doc($id);

		$this->session->set_flashdata('message', lang('admin verify del_success'));
		redirect(site_url("admin/verification"));
	}
}