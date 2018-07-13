<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Private_Controller {

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
        $this->load->model('orders_model');
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/orders'));
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
					
			$history = $this->orders_model->get_user_orders($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users orders title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->orders_model->get_user_orders($limit, $offset, $filters, $sort, $dir, $user['username']);
					
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
        $data['content'] = $this->load->view('account/orders/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
  
}