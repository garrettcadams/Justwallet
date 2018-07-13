<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Merchants extends Admin_Controller {
  
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
        $this->load->model('merchants_model');
        $this->load->model('users_model');
        $this->load->library('notice');
        $this->load->library('currencys');
      
      
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/merchants'));
        define('THIS_URL_2', base_url('admin/merchants/pending'));
        define('THIS_URL_3', base_url('admin/merchants/categories'));
        define('THIS_URL_4', base_url('admin/merchants/merchant_categories'));
				define('THIS_URL_5', base_url('admin/merchants/merchant_items'));
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
	* Merchant list
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
            $id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_string;
        }
    	if ($this->input->get('date', TRUE))
        {
            $date_xss = $this->security->xss_clean($this->input->get('date'));
            $date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
            $filters['date'] = $date_string;
        }
    		
    	if ($this->input->get('name', TRUE))
        {
            $name_xss = $this->security->xss_clean($this->input->get('name'));
            $name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
            $filters['name'] = $name_string;
        }
    		
        if ($this->input->get('link', TRUE))
        {
            $link_xss = $this->security->xss_clean($this->input->get('link'));
            $link_string = htmlentities($link_xss, ENT_QUOTES, "UTF-8");
            $filters['link'] = $link_string;
        }
    		
    	if ($this->input->get('user', TRUE))
        {
            $user_xss = $this->security->xss_clean($this->input->get('user'));
            $user_string = htmlentities($user_xss, ENT_QUOTES, "UTF-8");
            $filters['user'] = $user_string;
        }
    		
    	if ($this->input->get('category', TRUE))
        {
            $category_xss = $this->security->xss_clean($this->input->get('category'));
            $category_string = htmlentities($category_xss, ENT_QUOTES, "UTF-8");
            $filters['category'] = $category_string;
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
							
				if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
							
				if ($this->input->post('link'))
                {
                    $filter .= "&link=" . $this->input->post('link', TRUE);
                }
							
				if ($this->input->post('user'))
                {
                    $filter .= "&user=" . $this->input->post('user', TRUE);
                }
							
				if ($this->input->post('category'))
                {
                    $filter .= "&category=" . $this->input->post('category', TRUE);
                }
							
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_all_merchants($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_all_merchants($limit, $offset, $filters, $sort, $dir);
					
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
        $data['content'] = $this->load->view('admin/merchants/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	/**
	 * Merchant list
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
			
	    if ($this->input->get('id', TRUE))
        {
            $id_xss = $this->security->xss_clean($this->input->get('id'));
            $id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_string;
        }
        if ($this->input->get('date', TRUE))
        {
            $date_xss = $this->security->xss_clean($this->input->get('date'));
            $date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
            $filters['date'] = $date_string;
        }
            
        if ($this->input->get('name', TRUE))
        {
            $name_xss = $this->security->xss_clean($this->input->get('name'));
            $name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
            $filters['name'] = $name_string;
        }
            
        if ($this->input->get('link', TRUE))
        {
            $link_xss = $this->security->xss_clean($this->input->get('link'));
            $link_string = htmlentities($link_xss, ENT_QUOTES, "UTF-8");
            $filters['link'] = $link_string;
        }
            
        if ($this->input->get('user', TRUE))
        {
            $user_xss = $this->security->xss_clean($this->input->get('user'));
            $user_string = htmlentities($user_xss, ENT_QUOTES, "UTF-8");
            $filters['user'] = $user_string;
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
							
				if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
							
				if ($this->input->post('link'))
                {
                    $filter .= "&link=" . $this->input->post('link', TRUE);
                }
							
				if ($this->input->post('user'))
                {
                    $filter .= "&user=" . $this->input->post('user', TRUE);
                }
							
                // redirect using new filter(s)
                redirect(THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_pending_merchants($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_pending_merchants($limit, $offset, $filters, $sort, $dir);
					
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
        $data['content'] = $this->load->view('admin/merchants/pending', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	 /**
	 * Merchant categories
     */
	function merchant_categories()
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
            $id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_string;
        }

    	if ($this->input->get('date', TRUE))
        {
            $date_xss = $this->security->xss_clean($this->input->get('date'));
            $date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
            $filters['date'] = $date_string;
        }
		
		if ($this->input->get('name', TRUE))
        {
            $name_xss = $this->security->xss_clean($this->input->get('name'));
            $name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
            $filters['name'] = $name_string;
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
							
				if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_4 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_all_merchant_categories($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_all_merchant_categories($limit, $offset, $filters, $sort, $dir);
					
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
        $data['content'] = $this->load->view('admin/merchants/merchant_categories', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
  
    /**
	 * categories
     */

	function categories()
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
            $id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_string;
        }

        if ($this->input->get('date', TRUE))
        {
            $date_xss = $this->security->xss_clean($this->input->get('date'));
            $date_string = htmlentities($date_xss, ENT_QUOTES, "UTF-8");
            $filters['date'] = $date_string;
        }
        
        if ($this->input->get('name', TRUE))
        {
            $name_xss = $this->security->xss_clean($this->input->get('name'));
            $name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
            $filters['name'] = $name_string;
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
							
				if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL_3 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_all_categories($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_all_categories($limit, $offset, $filters, $sort, $dir);
					
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
        $data['content'] = $this->load->view('admin/merchants/categories', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	 /**
     * Edit merchant
     */
	function edit_merchant($id = NULL)
    {
		
    	// get parameters
        $offset = "0";
        $sort   = "id";
        $dir    = "desc";
    		
    	$categories = $this->merchants_model->get_select_categories($offset, $filters, $sort, $dir);
    		
    	$categories2 = $this->merchants_model->get_select_merchant_categories_all($offset, $filters, $sort, $dir, $id);
    		
    	$total = $categories['total'];
		
		// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
        	redirect($this->_redirect_url);
        }
		
		// get the data
        $merchant = $this->merchants_model->get_merchant($id);
		
		 // if empty results, return to list
        if ( ! $merchant)
        {
            redirect($this->_redirect_url);
        }
		
		$this->form_validation->set_rules('name', lang('users invoices name'), 'required|max_length[100]'); //
	    $this->form_validation->set_rules('fee', lang('admin settings fee'), 'required|numeric'); //
		$this->form_validation->set_rules('fix_fee', lang('admin settings fix_fee'), 'required|numeric'); //
		$this->form_validation->set_rules('status', lang('admins trans status'), 'required|in_list[1,2,3]'); //
		$this->form_validation->set_rules('success_link', lang('users shops merchant_success'), 'required|max_length[100]'); //
        $this->form_validation->set_rules('fail_link', lang('users shops merchant_fail'), 'required|max_length[100]'); //
		$this->form_validation->set_rules('link', lang('users merchants url'), 'required|max_length[100]'); //
		$this->form_validation->set_rules('status_link', lang('users merchants ipn'), 'required|max_length[100]'); //
        $this->form_validation->set_rules('password', lang('users shops merchant_password'), 'required|min_length[10]|max_length[100]'); //
		$this->form_validation->set_rules('category', lang('users shops categories'), 'required|numeric|callback__check_category[]'); //
        $this->form_validation->set_rules('show_category', lang('admin invoices description'), 'required|in_list[0,1]'); //
		$this->form_validation->set_rules('payeer_fee', lang('admin invoices description'), 'required|in_list[0,1]'); //
		$this->form_validation->set_rules('test_mode', lang('admin invoices description'), 'required|in_list[0,1]'); //
		$this->form_validation->set_rules('comment', lang('users merchants comment'), 'max_length[150]'); //
		$this->form_validation->set_rules('note_payment', lang('users merchants comment'), 'max_length[100]'); //
		
		if ($this->form_validation->run() == TRUE)
        {
					
			$config['upload_path']          = ''.$_SERVER['DOCUMENT_ROOT'].'/upload/logo';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 40000; // 5mb
			$config['encrypt_name']         = TRUE;
			$config['remove_spaces']        = TRUE;

			$this->load->library('upload', $config);

			$this->upload->do_upload('logo');

			if (! $this->upload->do_upload('logo')) {

				$logo = $merchant['logo'];

			} else {

				$logo = $this->upload->data('file_name');

			}
			
						$data = $this->security->xss_clean($this->input->post());

            // save the changes
            $saved = $this->merchants_model->edit_admin_merchant($data, $logo);

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin shops merchant_success'));
            }
            else
            {
				$this->session->set_flashdata('error', lang('admin shops merchant_fail'));
            }

            // return to list and display message
            redirect(site_url("admin/merchants"));

        }
		
		// setup page header data
        $this->set_title( lang('admin shops title') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'      => THIS_URL,
            'cancel_url'    => $this->_redirect_url,
            'merchant'      => $merchant,
            'merchant_id'   => $id,
			'categories'    => $categories['results'],
            'total'         => $categories['total'],
			'categories2'   => $categories2['results'],
			'total2'        => $categories2['total'],
        );

        // load views
        $data['content'] = $this->load->view('admin/merchants/edit_merchant', $content_data, TRUE);
        $this->load->view($this->template, $data);
		
	}
  
    /**
     * Edit category
     */
	function edit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $category = $this->merchants_model->get_category($id);

        // if empty results, return to list
        if ( ! $category)
        {
            redirect($this->_redirect_url);
        }
    
        foreach ($this->session->languages as $language_key=>$language_name)
        {

		  $this->form_validation->set_rules("name[" . $language_key . "]", lang('admin invoices name'), 'trim');
          $this->form_validation->set_rules('code', lang('admin events code'), 'required');
          $this->form_validation->set_rules('status', lang('admins trans status'), 'required|in_list[0,1]');

        }

        if ($this->form_validation->run() == TRUE)
        {
					
			$config['upload_path']          = ''.$_SERVER['DOCUMENT_ROOT'].'/upload/logo';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 40000; // 5mb
			$config['encrypt_name']         = TRUE;
			$config['remove_spaces']        = TRUE;

			$this->load->library('upload', $config);
					 
			$this->upload->do_upload('logo');
					 
			if (! $this->upload->do_upload('logo')) {
				
				$logo = $category['img'];

			} else {
						
				$logo = $this->upload->data('file_name');
						
			}
						$data = $this->security->xss_clean($this->input->post());
					 
            // save the changes
            $saved = $this->merchants_model->edit_merchant($data, $logo);

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin shops categories_success'));
            }
            else
            {
				$this->session->set_flashdata('error', lang('admin shops categories_fail'));
            }

            // return to list and display message
            redirect(site_url("admin/merchants/categories"));
        }

        // setup page header data
        $this->set_title( lang('admin shops title') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'      => THIS_URL,
            'cancel_url'    => $this->_redirect_url,
            'category'      => $category,
            'category_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/merchants/form', $content_data, TRUE);
        $this->load->view($this->template, $data);

    }
	
	/**
     * Add category
     */
	function add()
    {
		
		foreach ($this->session->languages as $language_key=>$language_name)
        {
		    $this->form_validation->set_rules("name[" . $language_key . "]", lang('admin invoices name'), 'trim');
            $this->form_validation->set_rules('status', lang('admins trans status'), 'required|in_list[0,1]');
        }

        if ($this->form_validation->run() == TRUE)
        {
			$code = uniqid("mcw_");
					 
            // save the changes
					 
			$config['upload_path']          = ''.$_SERVER['DOCUMENT_ROOT'].'/upload/logo';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 40000; // 5mb
			$config['encrypt_name']         = TRUE;
			$config['remove_spaces']        = TRUE;

			$this->load->library('upload', $config);

			$this->upload->do_upload('logo');

			if (! $this->upload->do_upload('logo')) {

				$logo = "shop.png";

			} else {

				$logo = $this->upload->data('file_name');

			}			
						$data = $this->security->xss_clean($this->input->post());
					 
            $saved = $this->merchants_model->add_merchant($data, $code, $logo);

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin shops categories_success'));
            }
            else
            {
				$this->session->set_flashdata('error', lang('admin shops categories_fail'));
            }

            // return to list and display message
            redirect(site_url("admin/merchants/categories"));
        }

        // setup page header data
        $this->set_title( lang('admin shops title') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   		   => THIS_URL,
            'cancel_url'           => $this->_redirect_url,
        );

        // load views
        $data['content'] = $this->load->view('admin/merchants/add', $content_data, TRUE);
        $this->load->view($this->template, $data);
		
	}
	
	/**
     * Edit item
     */
	function edit_item($id = NULL)
    {
        // get parameters
        $offset = "0";
        $sort   = "id";
        $dir    = "desc";
		
		// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
           redirect($this->_redirect_url);
        }
		
		$item = $this->merchants_model->get_item($id);
		
		$user = $this->users_model->get_username($item['user']);
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset, $filters, $sort, $dir, $item['merchant_id'], $user['username']);
		
		
		// setup page header data
        $this->set_title(sprintf(lang('admin shops title'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
			'categories'    => $categories['results'],
			'total'      => $categories['total'],
			'id'      => $id,
			'item'      => $item,
        );

        // load views
        $data['content'] = $this->load->view('admin/merchants/edit_item', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	
	
	function merchant_items()
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
            $id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
            $filters['id'] = $id_string;
        }

        if ($this->input->get('merchant_id', TRUE))
        {
            $merchant_id_xss = $this->security->xss_clean($this->input->get('merchant_id'));
            $merchant_id_string = htmlentities($merchant_id_xss, ENT_QUOTES, "UTF-8");
            $filters['merchant_id'] = $merchant_id_string;
        }
		
		
		if ($this->input->get('user', TRUE))
        {
            $user_xss = $this->security->xss_clean($this->input->get('user'));
            $user_string = htmlentities($user_xss, ENT_QUOTES, "UTF-8");
            $filters['user'] = $user_string;
        }

        if ($this->input->get('status', TRUE))
        {
            $status_xss = $this->security->xss_clean($this->input->get('status'));
            $status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
            $filters['status'] = $status_string;
        }
		
		if ($this->input->get('name', TRUE))
        {
            $name_xss = $this->security->xss_clean($this->input->get('name'));
            $name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
            $filters['name'] = $name_string;
        }

        if ($this->input->get('category_id', TRUE))
        {
            $category_id_xss = $this->security->xss_clean($this->input->get('category_id'));
            $category_id_string = htmlentities($category_id_xss, ENT_QUOTES, "UTF-8");
            $filters['category_id'] = $category_id_string;
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
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
							
				if ($this->input->post('merchant_id'))
                {
                    $filter .= "&merchant_id=" . $this->input->post('merchant_id', TRUE);
                }
							
				if ($this->input->post('user'))
                {
                    $filter .= "&user=" . $this->input->post('user', TRUE);
                }
							
				if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }
							
				if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
							
				if ($this->input->post('category_id'))
                {
                    $filter .= "&category_id=" . $this->input->post('category_id', TRUE);
                }
							
                // redirect using new filter(s)
                redirect(THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_all_items($limit, $offset, $filters, $sort, $dir);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('admin shops title'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_all_items($limit, $offset, $filters, $sort, $dir);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_5 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL_5,
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
        $data['content'] = $this->load->view('admin/merchants/merchant_items', $content_data, TRUE);
		$this->load->view($this->template, $data);

	}
	
	function delete_item($id)
    {
		// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
         	redirect($this->_redirect_url);
        }

	    $del = $this->merchants_model->delete_item($id);

		$this->session->set_flashdata('message', lang('admin shops it-del_success'));
		redirect(site_url("admin/merchants/merchant_items"));
	}
	
	  /**
	 * start edit item
     */
	function start_edit_item($id = NULL)
	{
		
		// get parameters
        $offset = "0";
        $sort   = "id";
        $dir    = "desc";
		
		// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
           redirect($this->_redirect_url);
        }
		
		$item = $this->merchants_model->get_item($id);
		
		$user = $this->users_model->get_username($item['user']);
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset, $filters, $sort, $dir, $item['merchant_id'], $user['username']);
		
        $this->form_validation->set_rules('name', lang('users invoices name'), 'required|max_length[100]|min_length[3]');
		$this->form_validation->set_rules('category_id', lang('users shops item_category'), 'required|numeric');
		$this->form_validation->set_rules('availability', lang('users shops availability'), 'required|numeric');
		$this->form_validation->set_rules('price', lang('users shops price'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		$this->form_validation->set_rules('about', lang('users invoices name'), 'required|max_length[3000]|min_length[3]');
		$this->form_validation->set_rules('download_link', lang('users shops item_link'), 'required|max_length[300]|min_length[3]|valid_url');
		$this->form_validation->set_rules('status', lang('users trans status'), 'required|trim|in_list[1,2]');
    
        if ($this->form_validation->run() == TRUE)
        {
			
			$config['upload_path']          = ''.$_SERVER['DOCUMENT_ROOT'].'/upload/items/img';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 40000; // 5mb
			$config['encrypt_name']         = TRUE;
			$config['remove_spaces']        = TRUE;
			
			$this->load->library('upload', $config);
			
			if (! $this->upload->do_upload('img')) {
				
				$img = $item['img'];
				
			} else {
				
				$img = $this->upload->data('file_name');
				
			}
			
			$name = $this->input->post("name", TRUE);
			$about = $this->input->post("about", TRUE);
			$category = $this->input->post("category_id", TRUE);
			$merchant_id = $item['merchant_id'];
			$availability = $this->input->post("availability", TRUE);
			$price = $this->input->post("price", TRUE);
			$download_link = $this->input->post("download_link", TRUE);
			$currency = $this->input->post("currency", TRUE);
			$status = $this->input->post("status", TRUE);
			
			// update transaction history
			$this->merchants_model->update_item($item['id'],
				array(
					"name"              => $name,
					"about"             => $about,
					"category_id"       => $category,
					"merchant_id"       => $merchant_id,
					"availability"      => $availability,
					"img"               => $img,
					"download_link"     => $download_link,
					"status"            => $status,
					"user"              => $user['username'],
					"price"             => $price,
					"currency"          => $currency,
				)
			);
			
			$this->session->set_flashdata('message', lang('users shops item_edit_success'));
			// return to list and display message
            redirect(site_url('admin/merchants/merchant_items'));
			
			
		} else {
			
			$this->session->set_flashdata('error', lang('users shops item_edit_fail'));
			// return to list and display message
            redirect(site_url('admin/merchants/merchant_items'));
			
		}
		
	}
	
	function delete($id)
    {
		// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
         	redirect($this->_redirect_url);
        }

	    $del = $this->merchants_model->delete($id);

		$this->session->set_flashdata('message', lang('admin shops categories_del'));
		redirect(site_url("admin/merchants/categories"));
	}
	

	function delete_merchant($id)
    {
		// make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
         	redirect($this->_redirect_url);
        }

	    $del = $this->merchants_model->delete_merchant($id);

		$this->session->set_flashdata('message', lang('admin shops del_success'));
		redirect(site_url("admin/merchants"));
	}
	
	
	
	/**************************************************************************************
    * PRIVATE VALIDATION CALLBACK FUNCTIONS
 **************************************************************************************/
	
	/**
     * Make sure category is available
     *
     * @param  string $username
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_category($category)
    {
        if ($this->merchants_model->category_exists($category))
        {
            $this->form_validation->set_message('_check_category', sprintf(lang('users error username_exists'), $category));
						return $category;
        }
        else
        {
            return FALSE;
        }
    }
  
}