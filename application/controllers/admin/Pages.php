<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Admin_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
			
			$this->load->helper('security');
      $this->load->model('pages_model');
			$this->load->model('support_model');
			$this->load->model('verification_model');
			$this->load->library('notice');

				
		// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/pages'));
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "id");
        define('DEFAULT_DIR', "asc");

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
     * All pages
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
					
			// get list
			$pages = $this->pages_model->get_all($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->set_title( lang('admin pages menu') );
			
		$data = $this->includes;

		// get list
		$pages = $this->pages_model->get_all($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $pages['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'              => THIS_URL,
            'pages'                 => $pages['results'],
            'total'                 => $pages['total'],
            'filters'               => $filters,
            'filter'                => $filter,
            'pagination'            => $this->pagination->create_links(),
            'limit'                 => $limit,
            'offset'                => $offset,
            'sort'                  => $sort,
            'dir'                   => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/pages/list', $content_data, TRUE);
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
        $page = $this->pages_model->get_page($id);

        // if empty results, return to list
        if ( ! $page)
        {
            redirect($this->_redirect_url);
        }
    
        foreach ($this->session->languages as $language_key=>$language_name)
        {
		      $this->form_validation->set_rules("content[" . $language_key . "]", lang('admin pages content'), 'trim');
        }

         if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->pages_model->edit_page($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin pages success'));
            }
            else
            {
				$this->session->set_flashdata('error', lang('admin pages fail'));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title( lang('admin pages edit') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   		   => THIS_URL,
            'cancel_url'           => $this->_redirect_url,
            'page'      => $page,
            'page_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/pages/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
		/**
     * Edit email template
     */
		function change($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $page = $this->pages_model->get_page($id);

        // if empty results, return to list
        if ( ! $page)
        {
            redirect($this->_redirect_url);
        }
    
        foreach ($this->session->languages as $language_key=>$language_name)
        {
		      $this->form_validation->set_rules("content[" . $language_key . "]", lang('admin pages content'), 'trim');
        }

         if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->pages_model->edit_page($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin pages success'));
            }
            else
            {
				$this->session->set_flashdata('error', lang('admin pages fail'));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title( lang('admin pages edit') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   		   => THIS_URL,
            'cancel_url'           => $this->_redirect_url,
            'page'      => $page,
            'page_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/pages/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
  }