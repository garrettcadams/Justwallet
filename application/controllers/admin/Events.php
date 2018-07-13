<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Admin_Controller {
	
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
        $this->load->model('events_model');
				$this->load->model('support_model');
				$this->load->model('verification_model');
				$this->load->library('notice');
			
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/events'));
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
     * Activity Log
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
			$logs = $this->events_model->get_all($limit, $offset, $filters, $sort, $dir);
					
        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admin events menu') );
		
        $data = $this->includes;
			
		// get list
		$logs = $this->events_model->get_all($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $logs['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
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
        $data['content'] = $this->load->view('admin/events/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
    /**
     * Delite logs
     */
	function clear_log() 
	{
		$this->events_model->clear_log();
		$this->session->set_flashdata('message', lang('admin currency msg save_success'));
		redirect(site_url("admin/events"));
	}

}