<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends Admin_Controller {
  
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
				$this->load->model('invoices_model');
				$this->load->library('notice');
        $this->load->library('currencys');
      
      
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/invoices'));
        define('THIS_URL_2', base_url('admin/invoices/pending'));
        define('THIS_URL_3', base_url('admin/invoices/confirmed'));
        define('THIS_URL_4', base_url('admin/invoices/declined'));
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
		// get parameters
    $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
    $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
    $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
    $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
		
		// get filters
    $filters = array();
			
		if ($this->input->get('id', TRUE))
    {
      $filters['id'] = $this->input->get('id', TRUE);;
    }
		if ($this->input->get('date'))
    {
       $filters['date'] = $this->input->get('date', TRUE);
    }
		
		if ($this->input->get('sender'))
    {
       $filters['sender'] = $this->input->get('sender', TRUE);
    }
		
		if ($this->input->get('receiver'))
    {
       $filters['receiver'] = $this->input->get('receiver', TRUE);
    }
		
		if ($this->input->get('amount'))
    {
       $filters['amount'] = $this->input->get('amount', TRUE);
    }
		
		if ($this->input->get('name'))
    {
       $filters['name'] = $this->input->get('name', TRUE);
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
								if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_all($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_all($limit, $offset, $filters, $sort, $dir);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
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
        $data['content'] = $this->load->view('admin/invoices/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
  
  function pending()
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
      $filters['id'] = $this->input->get('id', TRUE);;
    }
		if ($this->input->get('date'))
    {
       $filters['date'] = $this->input->get('date', TRUE);
    }
		
		if ($this->input->get('sender'))
    {
       $filters['sender'] = $this->input->get('sender', TRUE);
    }
		
		if ($this->input->get('receiver'))
    {
       $filters['receiver'] = $this->input->get('receiver', TRUE);
    }
		
		if ($this->input->get('amount'))
    {
       $filters['amount'] = $this->input->get('amount', TRUE);
    }
		
		if ($this->input->get('name'))
    {
       $filters['name'] = $this->input->get('name', TRUE);
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
            } else {

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
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_pending($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_pending($limit, $offset, $filters, $sort, $dir);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_2,
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
        $data['content'] = $this->load->view('admin/invoices/pending', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
  
  function confirmed()
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
      $filters['id'] = $this->input->get('id', TRUE);;
    }
		if ($this->input->get('date'))
    {
       $filters['date'] = $this->input->get('date', TRUE);
    }
		
		if ($this->input->get('sender'))
    {
       $filters['sender'] = $this->input->get('sender', TRUE);
    }
		
		if ($this->input->get('receiver'))
    {
       $filters['receiver'] = $this->input->get('receiver', TRUE);
    }
		
		if ($this->input->get('amount'))
    {
       $filters['amount'] = $this->input->get('amount', TRUE);
    }
		
		if ($this->input->get('name'))
    {
       $filters['name'] = $this->input->get('name', TRUE);
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
            } else {

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
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_confirmed($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_confirmed($limit, $offset, $filters, $sort, $dir);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_3,
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
        $data['content'] = $this->load->view('admin/invoices/confirmed', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
  
  function declined()
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
      $filters['id'] = $this->input->get('id', TRUE);;
    }
		if ($this->input->get('date'))
    {
       $filters['date'] = $this->input->get('date', TRUE);
    }
		
		if ($this->input->get('sender'))
    {
       $filters['sender'] = $this->input->get('sender', TRUE);
    }
		
		if ($this->input->get('receiver'))
    {
       $filters['receiver'] = $this->input->get('receiver', TRUE);
    }
		
		if ($this->input->get('amount'))
    {
       $filters['amount'] = $this->input->get('amount', TRUE);
    }
		
		if ($this->input->get('name'))
    {
       $filters['name'] = $this->input->get('name', TRUE);
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
            } else {

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
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->invoices_model->get_declined($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin invoices menu'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->invoices_model->get_declined($limit, $offset, $filters, $sort, $dir);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_4,
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
        $data['content'] = $this->load->view('admin/invoices/declined', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
  
  /**
     * Edit invoice
     */
	function detail($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $invoice = $this->invoices_model->get_invoice($id);

        // if empty results, return to list
        if ( ! $invoice)
        {
            redirect($this->_redirect_url);
        }
    
        $this->form_validation->set_rules('sender', lang('admins trans sender'), 'required');
        $this->form_validation->set_rules('receiver', lang('admins trans receiver'), 'required');
        $this->form_validation->set_rules('code', lang('admin invoices label'), 'required|max_length[100]');
        $this->form_validation->set_rules('name', lang('admin invoices name'), 'max_length[200]');
        $this->form_validation->set_rules('info', lang('admin invoices description'), 'max_length[2000]');
    
        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->invoices_model->edit_invoice($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin invoices success_4'));
            }
            else
            {
				        $this->session->set_flashdata('error', lang('admin invoices error_4'));
            }

            // return to list and display message
            redirect(site_url("admin/invoices"));
        }

        // setup page header data
        $this->set_title( lang('admin invoices menu') );

        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'invoice'      => $invoice,
            'invoice_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/invoices/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }	
  
  function delete($id)
  {
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
     	redirect($this->_redirect_url);
    }

	  $del = $this->invoices_model->delete($id);

		$this->session->set_flashdata('message', lang('admin invoices del'));
		redirect(site_url("admin/invoices"));
	}
  
}