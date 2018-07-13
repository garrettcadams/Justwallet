<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Disputes extends Admin_Controller {
	
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
			
			
		// load the logs model
		$this->load->library('currencys');
    	$this->load->model('disputes_model');
		$this->load->model('users_model');
		$this->load->model('transactions_model');
		$this->load->model('template_model');
			
		// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/disputes'));
        define('THIS_URL_2', base_url('admin/disputes/open_claims'));
        define('THIS_URL_3', base_url('admin/disputes/open_disputes'));
        define('THIS_URL_4', base_url('admin/disputes/rejected_disputes'));
        define('THIS_URL_5', base_url('admin/disputes/satisfied_disputes'));
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
    * Disputes list
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
			$id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
			$filters['id'] = $id_string;
        }
			
		if ($this->input->get('transaction'))
        {
			$transaction_xss = $this->security->xss_clean($this->input->get('transaction'));
			$transaction_string = htmlentities($transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['transaction'] = $transaction_string;
        }

        if ($this->input->get('time_transaction'))
        {
			$time_transaction_xss = $this->security->xss_clean($this->input->get('time_transaction'));
			$time_transaction_string = htmlentities($time_transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['time_transaction'] = $time_transaction_string;
        }
			
		if ($this->input->get('time_dispute'))
        {
			$time_dispute_xss = $this->security->xss_clean($this->input->get('time_dispute'));
			$time_dispute_string = htmlentities($time_dispute_xss, ENT_QUOTES, "UTF-8");
			$filters['time_dispute'] = $time_dispute_string;
        }
			
		if ($this->input->get('claimant'))
        {
			$claimant_xss = $this->security->xss_clean($this->input->get('claimant'));
			$claimant_string = htmlentities($claimant_xss, ENT_QUOTES, "UTF-8");
			$filters['claimant'] = $claimant_string;
        }
			
		if ($this->input->get('defendant'))
        {
			$defendant_xss = $this->security->xss_clean($this->input->get('defendant'));
			$defendant_string = htmlentities($defendant_xss, ENT_QUOTES, "UTF-8");
			$filters['defendant'] = $defendant_string;
        }
				
		if ($this->input->get('status'))
        {
			$status_xss = $this->security->xss_clean($this->input->get('status'));
			$status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
			$filters['status'] = $status_string;
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
							
				if ($this->input->post('transaction'))
                {
                    $filter .= "&transaction=" . $this->input->post('transaction', TRUE);
                }

                if ($this->input->post('time_transaction'))
                {
                    $filter .= "&time_transaction=" . $this->input->post('time_transaction', TRUE);
                }

                if ($this->input->post('time_dispute'))
                {
                    $filter .= "&time_dispute=" . $this->input->post('time_dispute', TRUE);
                }
							
				if ($this->input->post('claimant'))
                {
                    $filter .= "&claimant=" . $this->input->post('claimant', TRUE);
                }
							
				if ($this->input->post('defendant'))
                {
                    $filter .= "&defendant=" . $this->input->post('defendant', TRUE);
                }
							
				if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$disputes = $this->disputes_model->get_all($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title disputes') );
		
        $data = $this->includes;
			
		// get list
		$disputes = $this->disputes_model->get_all($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $disputes['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'disputes'   => $disputes['results'],
            'total'      => $disputes['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/disputes/index', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    /**
    * Disputes list pending
    */
    function open_claims()
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
			
		if ($this->input->get('transaction'))
        {
			$transaction_xss = $this->security->xss_clean($this->input->get('transaction'));
			$transaction_string = htmlentities($transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['transaction'] = $transaction_string;
        }

        if ($this->input->get('time_transaction'))
        {
			$time_transaction_xss = $this->security->xss_clean($this->input->get('time_transaction'));
			$time_transaction_string = htmlentities($time_transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['time_transaction'] = $time_transaction_string;
        }
			
		if ($this->input->get('time_dispute'))
        {
			$time_dispute_xss = $this->security->xss_clean($this->input->get('time_dispute'));
			$time_dispute_string = htmlentities($time_dispute_xss, ENT_QUOTES, "UTF-8");
			$filters['time_dispute'] = $time_dispute_string;
        }
			
		if ($this->input->get('claimant'))
        {
			$claimant_xss = $this->security->xss_clean($this->input->get('claimant'));
			$claimant_string = htmlentities($claimant_xss, ENT_QUOTES, "UTF-8");
			$filters['claimant'] = $claimant_string;
        }
			
		if ($this->input->get('defendant'))
        {
			$defendant_xss = $this->security->xss_clean($this->input->get('defendant'));
			$defendant_string = htmlentities($defendant_xss, ENT_QUOTES, "UTF-8");
			$filters['defendant'] = $defendant_string;
        }
				
		if ($this->input->get('status'))
        {
			$status_xss = $this->security->xss_clean($this->input->get('status'));
			$status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
			$filters['status'] = $status_string;
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
							
				if ($this->input->post('transaction'))
                {
                    $filter .= "&transaction=" . $this->input->post('transaction', TRUE);
                }

                if ($this->input->post('time_transaction'))
                {
                    $filter .= "&time_transaction=" . $this->input->post('time_transaction', TRUE);
                }

                if ($this->input->post('time_dispute'))
                {
                    $filter .= "&time_dispute=" . $this->input->post('time_dispute', TRUE);
                }
							
				if ($this->input->post('claimant'))
                {
                    $filter .= "&claimant=" . $this->input->post('claimant', TRUE);
                }
							
				if ($this->input->post('defendant'))
                {
                    $filter .= "&defendant=" . $this->input->post('defendant', TRUE);
                }
							
				if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$disputes = $this->disputes_model->get_open_claims($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title disputes') );
		
        $data = $this->includes;
			
		// get list
		$disputes = $this->disputes_model->get_open_claims($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $disputes['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_2,
            'disputes'   => $disputes['results'],
            'total'      => $disputes['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/disputes/open_claims', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    /**
    * Disputes list pending
    */
    function open_disputes()
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
			
		if ($this->input->get('transaction'))
        {
			$transaction_xss = $this->security->xss_clean($this->input->get('transaction'));
			$transaction_string = htmlentities($transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['transaction'] = $transaction_string;
        }

        if ($this->input->get('time_transaction'))
        {
			$time_transaction_xss = $this->security->xss_clean($this->input->get('time_transaction'));
			$time_transaction_string = htmlentities($time_transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['time_transaction'] = $time_transaction_string;
        }
			
		if ($this->input->get('time_dispute'))
        {
			$time_dispute_xss = $this->security->xss_clean($this->input->get('time_dispute'));
			$time_dispute_string = htmlentities($time_dispute_xss, ENT_QUOTES, "UTF-8");
			$filters['time_dispute'] = $time_dispute_string;
        }
			
		if ($this->input->get('claimant'))
        {
			$claimant_xss = $this->security->xss_clean($this->input->get('claimant'));
			$claimant_string = htmlentities($claimant_xss, ENT_QUOTES, "UTF-8");
			$filters['claimant'] = $claimant_string;
        }
			
		if ($this->input->get('defendant'))
        {
			$defendant_xss = $this->security->xss_clean($this->input->get('defendant'));
			$defendant_string = htmlentities($defendant_xss, ENT_QUOTES, "UTF-8");
			$filters['defendant'] = $defendant_string;
        }
				
		if ($this->input->get('status'))
        {
			$status_xss = $this->security->xss_clean($this->input->get('status'));
			$status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
			$filters['status'] = $status_string;
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
							
				if ($this->input->post('transaction'))
                {
                    $filter .= "&transaction=" . $this->input->post('transaction', TRUE);
                }

                if ($this->input->post('time_transaction'))
                {
                    $filter .= "&time_transaction=" . $this->input->post('time_transaction', TRUE);
                }

                if ($this->input->post('time_dispute'))
                {
                    $filter .= "&time_dispute=" . $this->input->post('time_dispute', TRUE);
                }
							
				if ($this->input->post('claimant'))
                {
                    $filter .= "&claimant=" . $this->input->post('claimant', TRUE);
                }
							
				if ($this->input->post('defendant'))
                {
                    $filter .= "&defendant=" . $this->input->post('defendant', TRUE);
                }
							
				if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$disputes = $this->disputes_model->get_open_disputes($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title disputes') );
		
        $data = $this->includes;
			
		// get list
		$disputes = $this->disputes_model->get_open_disputes($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $disputes['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_3,
            'disputes'   => $disputes['results'],
            'total'      => $disputes['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/disputes/open_disputes', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	/**
    * Disputes list pending
    */
    function rejected_disputes()
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
			
		if ($this->input->get('transaction'))
        {
			$transaction_xss = $this->security->xss_clean($this->input->get('transaction'));
			$transaction_string = htmlentities($transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['transaction'] = $transaction_string;
        }

        if ($this->input->get('time_transaction'))
        {
			$time_transaction_xss = $this->security->xss_clean($this->input->get('time_transaction'));
			$time_transaction_string = htmlentities($time_transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['time_transaction'] = $time_transaction_string;
        }
			
		if ($this->input->get('time_dispute'))
        {
			$time_dispute_xss = $this->security->xss_clean($this->input->get('time_dispute'));
			$time_dispute_string = htmlentities($time_dispute_xss, ENT_QUOTES, "UTF-8");
			$filters['time_dispute'] = $time_dispute_string;
        }
			
		if ($this->input->get('claimant'))
        {
			$claimant_xss = $this->security->xss_clean($this->input->get('claimant'));
			$claimant_string = htmlentities($claimant_xss, ENT_QUOTES, "UTF-8");
			$filters['claimant'] = $claimant_string;
        }
			
		if ($this->input->get('defendant'))
        {
			$defendant_xss = $this->security->xss_clean($this->input->get('defendant'));
			$defendant_string = htmlentities($defendant_xss, ENT_QUOTES, "UTF-8");
			$filters['defendant'] = $defendant_string;
        }
				
		if ($this->input->get('status'))
        {
			$status_xss = $this->security->xss_clean($this->input->get('status'));
			$status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
			$filters['status'] = $status_string;
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
							
				if ($this->input->post('transaction'))
                {
                    $filter .= "&transaction=" . $this->input->post('transaction', TRUE);
                }

                if ($this->input->post('time_transaction'))
                {
                    $filter .= "&time_transaction=" . $this->input->post('time_transaction', TRUE);
                }

                if ($this->input->post('time_dispute'))
                {
                    $filter .= "&time_dispute=" . $this->input->post('time_dispute', TRUE);
                }
							
				if ($this->input->post('claimant'))
                {
                    $filter .= "&claimant=" . $this->input->post('claimant', TRUE);
                }
							
				if ($this->input->post('defendant'))
                {
                    $filter .= "&defendant=" . $this->input->post('defendant', TRUE);
                }
							
				if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$disputes = $this->disputes_model->get_rejected_disputes($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title disputes') );
		
        $data = $this->includes;
			
		// get list
		$disputes = $this->disputes_model->get_rejected_disputes($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $disputes['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_4,
            'disputes'   => $disputes['results'],
            'total'      => $disputes['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/disputes/rejected_disputes', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
    /**
    * Disputes list pending
    */
    function satisfied_disputes()
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
			
		if ($this->input->get('transaction'))
        {
			$transaction_xss = $this->security->xss_clean($this->input->get('transaction'));
			$transaction_string = htmlentities($transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['transaction'] = $transaction_string;
        }

        if ($this->input->get('time_transaction'))
        {
			$time_transaction_xss = $this->security->xss_clean($this->input->get('time_transaction'));
			$time_transaction_string = htmlentities($time_transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['time_transaction'] = $time_transaction_string;
        }
			
		if ($this->input->get('time_dispute'))
        {
			$time_dispute_xss = $this->security->xss_clean($this->input->get('time_dispute'));
			$time_dispute_string = htmlentities($time_dispute_xss, ENT_QUOTES, "UTF-8");
			$filters['time_dispute'] = $time_dispute_string;
        }
			
		if ($this->input->get('claimant'))
        {
			$claimant_xss = $this->security->xss_clean($this->input->get('claimant'));
			$claimant_string = htmlentities($claimant_xss, ENT_QUOTES, "UTF-8");
			$filters['claimant'] = $claimant_string;
        }
			
		if ($this->input->get('defendant'))
        {
			$defendant_xss = $this->security->xss_clean($this->input->get('defendant'));
			$defendant_string = htmlentities($defendant_xss, ENT_QUOTES, "UTF-8");
			$filters['defendant'] = $defendant_string;
        }
				
		if ($this->input->get('status'))
        {
			$status_xss = $this->security->xss_clean($this->input->get('status'));
			$status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
			$filters['status'] = $status_string;
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
							
				if ($this->input->post('transaction'))
                {
                    $filter .= "&transaction=" . $this->input->post('transaction', TRUE);
                }

                if ($this->input->post('time_transaction'))
                {
                    $filter .= "&time_transaction=" . $this->input->post('time_transaction', TRUE);
                }

                if ($this->input->post('time_dispute'))
                {
                    $filter .= "&time_dispute=" . $this->input->post('time_dispute', TRUE);
                }
							
				if ($this->input->post('claimant'))
                {
                    $filter .= "&claimant=" . $this->input->post('claimant', TRUE);
                }
							
				if ($this->input->post('defendant'))
                {
                    $filter .= "&defendant=" . $this->input->post('defendant', TRUE);
                }
							
				if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			// get list
			$disputes = $this->disputes_model->get_satisfied_disputes($limit, $offset, $filters, $sort, $dir);

        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admins title disputes') );
		
        $data = $this->includes;
			
		// get list
		$disputes = $this->disputes_model->get_satisfied_disputes($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $disputes['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_5,
            'disputes'   => $disputes['results'],
            'total'      => $disputes['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
		$data['content'] = $this->load->view('admin/disputes/satisfied_disputes', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

	/**
     * Edit transaction
     */
	function detail($id = NULL)
    {

        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $disputes = $this->disputes_model->get_disputes($id);

        // if empty results, return to list
        if ( ! $disputes)
        {
            redirect($this->_redirect_url);
        }

		$this->form_validation->set_rules('time_transaction', lang('admin disputes id_tran_time'), 'required');
		$this->form_validation->set_rules('time_dispute', lang('admin disputes time_dispute'), 'required');
		$this->form_validation->set_rules('claimant', lang('admin disputes claimant'), 'required');
		$this->form_validation->set_rules('defendant', lang('admin disputes defendant'), 'required');
		$this->form_validation->set_rules('sum', lang('admin trans sum'), 'required');
		$this->form_validation->set_rules('fee', lang('admin trans fee'), 'required');
		$this->form_validation->set_rules('amount', lang('admin trans amount'), 'required');
			
		$log_comment = $this->disputes_model->get_log_comment($disputes['id']);

        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->disputes_model->edit_dispute($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin disputes success'));
            }
            else
            {
    			$this->session->set_flashdata('error', lang('users error edit_user_failed'));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title( lang('admins title edit_dispute') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   	=> THIS_URL,
            'cancel_url'    => $this->_redirect_url,
            'disputes'      => $disputes,
			'log_comment'   => $log_comment,
            'disputes_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/disputes/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);

    }
	
	/**
     * Add admin comment
     */
	function add_comment()
	{
		
		$this->form_validation->set_rules('comment', lang('admin tickets enter'), 'required|min_length[10]|max_length[10000]');
    	$this->form_validation->set_rules('id', lang('admins trans id'), 'required|trim');
		
		if ($this->form_validation->run() == FALSE) {
      
      		$this->session->set_flashdata('error', lang('admin disputes fail'));
			redirect(site_url("admin/disputes"));
      
    	} else {
			
			$comment = $this->input->post("comment", TRUE);
			$id = $this->input->post("id", TRUE);
			
			$disputes = $this->disputes_model->get_disputes($id);
			$user = $this->users_model->get_username($disputes['defendant']);
			$user2 = $this->users_model->get_username($disputes['claimant']);
			
			if ($disputes['status'] != 3 & $disputes['status'] != 4) {
			
				$comments = $this->disputes_model->add_admin_comment(array(
					"id_dispute" 	  => $disputes['id'],
					"time"          => date('Y-m-d H:i:s'),
					"user"          => $this->settings->site_name,
					"role"          => "2",
					"comment"       => $comment,
					)
				);
				
				$user_mail1 = $this->users_model->get_username($disputes['claimant']);
							
				$user_mail2 = $this->users_model->get_username($disputes['defendant']);
						
				$email_template = $this->template_model->get_email_template(13);
								
				if($email_template['status'] == "1") {
			
					// variables to replace
					$site_name = $this->settings->site_name;
					$link = site_url('account/disputes');
					$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

					$rawstring = $email_template['message'];

					// what will we replace
					$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

					$vals_1 = array($site_name, $link, $name_user, $disputes['id']);

					//replace
					$str_1 = str_replace($placeholders, $vals_1, $rawstring);

					$this -> email -> from($this->settings->site_email, $this->settings->site_name);
					$this->email->to($user_mail1['email']);
					//$this -> email -> to($user['email']);
					$this -> email -> subject($email_template['title']);

					$this -> email -> message($str_1);

					$this->email->send();

				}
						
				if($email_template['status'] == "1") {
			
					// variables to replace
					$site_name = $this->settings->site_name;
					$link = site_url('account/disputes');
					$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

					$rawstring = $email_template['message'];

					// what will we replace
					$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

					$vals_1 = array($site_name, $link, $name_user, $disputes['id']);

					//replace
					$str_1 = str_replace($placeholders, $vals_1, $rawstring);

					$this -> email -> from($this->settings->site_email, $this->settings->site_name);
					$this->email->to($user_mail2['email']);
					//$this -> email -> to($user['email']);
					$this -> email -> subject($email_template['title']);

					$this -> email -> message($str_1);

					$this->email->send();

				}

				$this->session->set_flashdata('message', lang('admins disputes success_com'));
				redirect(site_url("admin/disputes"));
			
			} else {
			
				$this->session->set_flashdata('error', lang('admin disputes fail'));
				redirect(site_url("admin/disputes"));
			
			}
			
		}
		
	}
	
	/**
     * Reject dispute
     */
	function reject($id)
	{
		
		// get the data
    	$disputes = $this->disputes_model->get_disputes($id);
		$user = $this->users_model->get_username($disputes['defendant']);
		$user2 = $this->users_model->get_username($disputes['claimant']);
		
		if ($disputes['status'] == 2) {

			// update dispute
			$this->disputes_model->update_dispute($id,
				array(
					"status"   => "3",
				)
			);

			// update transaction history
			$this->transactions_model->update_dispute_transactions($disputes['transaction'],
				array(
					"status"   => "2",
				)
			);

			// add notification comment listing
			$comments = $this->disputes_model->new_comment(array(
				"id_dispute" 	    => $disputes['id'],
				"user" 		        => $this->settings->site_name,
				"role" 		        => "3",
				"comment" 		    => lang('admins disputes open_reject'),
				"time"            	=> date('Y-m-d H:i:s'),
				)
			);
			
			$user_mail1 = $this->users_model->get_username($disputes['claimant']);
							
			$user_mail2 = $this->users_model->get_username($disputes['defendant']);
				
			$email_template = $this->template_model->get_email_template(15);
								
			if($email_template['status'] == "1") {
			
				// variables to replace
				$site_name = $this->settings->site_name;
				$link = site_url('account/disputes');
				$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

				$rawstring = $email_template['message'];

				// what will we replace
				$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

				$vals_1 = array($site_name, $link, $name_user, $disputes['id']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$this -> email -> from($this->settings->site_email, $this->settings->site_name);
				$this->email->to($user_mail1['email']);
				//$this -> email -> to($user['email']);
				$this -> email -> subject($email_template['title']);

				$this -> email -> message($str_1);

				$this->email->send();

			}
						
			if($email_template['status'] == "1") {
			
				// variables to replace
				$site_name = $this->settings->site_name;
				$link = site_url('account/disputes');
				$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

				$rawstring = $email_template['message'];

				// what will we replace
				$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

				$vals_1 = array($site_name, $link, $name_user, $disputes['id']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$this -> email -> from($this->settings->site_email, $this->settings->site_name);
				$this->email->to($user_mail2['email']);
				//$this -> email -> to($user['email']);
				$this -> email -> subject($email_template['title']);

				$this -> email -> message($str_1);

				$this->email->send();

			}
			
			$sms_template = $this->template_model->get_sms_template(13);
			
			if($sms_template['status'] == "1") {
										
				$rawstring = $sms_template['message'];

				// what will we replace
				$placeholders = array('[ID_DISPUTE]');

				$vals_1 = array($disputes['id']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$result = $this->sms->send_sms($user_mail1['phone'], $str_1);
										
			}
				
			if($sms_template['status'] == "1") {
										
				$rawstring = $sms_template['message'];

				// what will we replace
				$placeholders = array('[ID_DISPUTE]');

				$vals_1 = array($disputes['id']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$result = $this->sms->send_sms($user_mail2['phone'], $str_1);
										
			}

			$this->session->set_flashdata('message', lang('admins disputes success_reject'));
			redirect(site_url("admin/disputes"));
			
		} else {
			
			$this->session->set_flashdata('error', lang('admin error global'));
			redirect(site_url("admin/disputes"));
			
		}
		
	}
	
	/**
     * Full refund
     */
	function full_refund($id)
	{
		
		// get the data
    	$disputes = $this->disputes_model->get_disputes($id);
		$user = $this->users_model->get_username($disputes['defendant']);
		$users = $this->users_model->get_username($disputes['claimant']);
		$wallet = $disputes['currency'];
		$amount = $disputes['amount'];
		
		if ($disputes['status'] == 2) {
		
			// update dispute
			$this->disputes_model->update_dispute($id,
				array(
					"status"   => "4",
				)
			);

			// Calculation of the amount to debit the defendant's account
			$refund = $user[$wallet]-$amount;

			// Calculation of the amount to be credited to the claimant 
			$return = $users[$wallet]+$amount;

			// update defendant fraud status and wallet
			$this->users_model->update_user($disputes['defendant'],
				array(
					$disputes['currency']  => $refund,
				)
			);

			// update claimant wallet
			$this->users_model->update_user($disputes['claimant'],
				array(
					$disputes['currency']  => $return,
				)
			);

			// add notification comment listing
			$comments = $this->disputes_model->new_comment(array(
				"id_dispute" 	  => $disputes['id'],
				"user" 		      => $this->settings->site_name,
				"role" 		      => "3",
				"comment" 		  => lang('admins disputes open_satisfy'),
				"time"            => date('Y-m-d H:i:s'),
				)
			);

			// update transaction history
			$this->transactions_model->update_dispute_transactions($disputes['transaction'],
				array(
					"status"   		=> "3",
				)
			);
			
			$user_mail1 = $this->users_model->get_username($disputes['claimant']);
							
			$user_mail2 = $this->users_model->get_username($disputes['defendant']);
						
			$email_template = $this->template_model->get_email_template(21);
								
			if($email_template['status'] == "1") {
			
				// variables to replace
				$site_name = $this->settings->site_name;
				$link = site_url('account/disputes');
				$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

				$rawstring = $email_template['message'];

				// what will we replace
				$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]', '[ID_TRANSACTION]');

				$vals_1 = array($site_name, $link, $name_user, $disputes['id'], $disputes['transaction']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$this -> email -> from($this->settings->site_email, $this->settings->site_name);
				$this->email->to($user_mail1['email']);
				//$this -> email -> to($user['email']);
				$this -> email -> subject($email_template['title']);

				$this -> email -> message($str_1);

				$this->email->send();

			}
						
			if($email_template['status'] == "1") {
			
				// variables to replace
				$site_name = $this->settings->site_name;
				$link = site_url('account/disputes');
				$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

				$rawstring = $email_template['message'];

				// what will we replace
				$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]', '[ID_TRANSACTION]');

				$vals_1 = array($site_name, $link, $name_user, $disputes['id'], $disputes['transaction']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$this -> email -> from($this->settings->site_email, $this->settings->site_name);
				$this->email->to($user_mail2['email']);
				//$this -> email -> to($user['email']);
				$this -> email -> subject($email_template['title']);

				$this -> email -> message($str_1);

				$this->email->send();

			}
			
			$sms_template = $this->template_model->get_sms_template(14);
			
			if($sms_template['status'] == "1") {
										
				$rawstring = $sms_template['message'];

				// what will we replace
				$placeholders = array('[ID_DISPUTE]');

				$vals_1 = array($disputes['id']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$result = $this->sms->send_sms($user_mail1['phone'], $str_1);
										
			}
				
			if($sms_template['status'] == "1") {
										
				$rawstring = $sms_template['message'];

				// what will we replace
				$placeholders = array('[ID_DISPUTE]');

				$vals_1 = array($disputes['id']);

				//replace
				$str_1 = str_replace($placeholders, $vals_1, $rawstring);

				$result = $this->sms->send_sms($user_mail2['phone'], $str_1);
										
			}

			$this->session->set_flashdata('message', lang('admins disputes success_satisfy'));
			redirect(site_url("admin/disputes"));
			
		} else {
			
			$this->session->set_flashdata('error', lang('admin error global'));
			redirect(site_url("admin/disputes"));
			
		}
		
	}
	
	function partially_refund()
	{
		
		$this->form_validation->set_rules('amount', lang('admin disputes detaill_refund'), 'required|numeric');
    	$this->form_validation->set_rules('id', lang('admins trans id'), 'required|trim');
		
		if ($this->form_validation->run() == FALSE) {
      
      		$this->session->set_flashdata('error', lang('admin error global'));
			redirect(site_url("admin/disputes"));
      
    	} else {
			
			$amount_refund = $this->input->post("amount", TRUE);
			$id = $this->input->post("id", TRUE);
			
			// get the data
			$disputes = $this->disputes_model->get_disputes($id);
			$user = $this->users_model->get_username($disputes['defendant']);
			$users = $this->users_model->get_username($disputes['claimant']);
			$wallet = $disputes['currency'];
			
			if ($disputes['status'] == 2) {
			
				// update dispute
				$this->disputes_model->update_dispute($id,
					array(
						"status"   => "4",
					)
				);
				
				// update transaction history
				$this->transactions_model->update_dispute_transactions($disputes['transaction'],
					array(
						"status"   		=> "2",
					)
				);
				
				// add notification comment listing
				$comments = $this->disputes_model->new_comment(array(
					"id_dispute" 		=> $disputes['id'],
					"user" 		      => $this->settings->site_name,
					"role" 		      => "3",
					"comment" 		  => lang('admin disputes cooment_part_satisfy'),
					"time"          => date('Y-m-d H:i:s'),
					)
				);

				// Calculation of the amount to debit the defendant's account
				$refund = $user[$wallet]-$amount_refund;

				// Calculation of the amount to be credited to the claimant 
				$return = $users[$wallet]+$amount_refund;

				// update defendant fraud status and wallet
				$this->users_model->update_user($disputes['defendant'],
					array(
						$disputes['currency']  => $refund,
					)
				);

				// update claimant wallet
				$this->users_model->update_user($disputes['claimant'],
					array(
						$disputes['currency']  => $return,
					)
				);

				$label = uniqid("rtd_");

				// add transaction for sender
				$transactions = $this->transactions_model->add_transaction(array(
					"type" 				=> "1",
					"sum"  				=> $amount_refund,
					"fee"    			=> "0.00",
					"amount" 			=> $amount_refund,
					"currency"			=> $wallet,
					"status" 			=> "2",
					"sender" 			=> "system",
					"receiver" 			=> $disputes['claimant'],
					"time"          	=> date('Y-m-d H:i:s'),
					"user_comment"  	=> 'Partially refund ID dispute '.$disputes['id'].', ID disputed transaction '.$disputes['transaction'].'',
					"label" 	    	=> $label,
					"ip_address" 		=> "0.000.000.00",
					"protect" 	  		=> "none",
					)
				);
				
			} else {
				
				$this->session->set_flashdata('error', lang('admin error global'));
				redirect(site_url("admin/disputes"));
				
			}
			
		}
			
	}

}