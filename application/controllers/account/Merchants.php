<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Merchants extends Private_Controller {

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
				$this->load->model('cart_model');
				$this->load->model('orders_model');
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/merchants'));
				define('THIS_URL_2', base_url('account/merchants/categories'));
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
		
		if ($this->input->get('name'))
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
                redirect(THIS_URL);
            } else {

                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->merchants_model->get_user_merchants($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops merchant'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->merchants_model->get_user_merchants($limit, $offset, $filters, $sort, $dir, $user['username']);
					
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
        $data['content'] = $this->load->view('account/merchants/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	  /**
	 * Default
     */

	function items($id = NULL)
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$check_merchant = $this->merchants_model->get_merchant($id);
		
		if ($user['username'] != $check_merchant['user']) {
			
			 redirect($this->_redirect_url);
			
		}
		
		$coreect_url = base_url('account/merchants/items/'.$id.'');
		
		// get parameters
    $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
    $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
    $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
    $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
		
		$offset2 = "0";
    $sort2   = "id";
    $dir2    = "desc";
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset2, $filters, $sort2, $dir2, $id, $user['username']);
		
		// get filters
    $filters = array();
			
		if ($this->input->get('id', TRUE))
    {
      $id_xss = $this->security->xss_clean($this->input->get('id'));
			$id_string = htmlentities($id_xss, ENT_QUOTES, "UTF-8");
			$filters['id'] = $id_string;
    }
		
		if ($this->input->get('name'))
    {
      $name_xss = $this->security->xss_clean($this->input->get('name'));
			$name_string = htmlentities($name_xss, ENT_QUOTES, "UTF-8");
			$filters['name'] = $name_string;
    }
		
		if ($this->input->get('status', TRUE))
    {
      $status_xss = $this->security->xss_clean($this->input->get('status'));
			$status_string = htmlentities($status_xss, ENT_QUOTES, "UTF-8");
			$filters['status'] = $status_string;
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
                redirect($coreect_url);
            } else {

							$offset2 = "0";
							$sort2   = "id";
							$dir2    = "desc";

							$categories = $this->merchants_model->get_select_merchant_categories($offset2, $filters, $sort2, $dir2, $id, $user['username']);
							
							
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }
							
								if ($this->input->post('name'))
                {
                    $filter .= "&name=" . $this->input->post('name', TRUE);
                }
							
								if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }
							
								if ($this->input->post('category_id'))
                {
                    $filter .= "&category_id=" . $this->input->post('category_id', TRUE);
                }
							
                // redirect using new filter(s)
                redirect($coreect_url . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$items = $this->merchants_model->get_user_items($limit, $offset, $filters, $sort, $dir, $id, $user['username']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops merchant'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$items = $this->merchants_model->get_user_items($limit, $offset, $filters, $sort, $dir, $id, $user['username']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => $coreect_url . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $items['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => $coreect_url,
            'items'    => $items['results'],
            'total'      => $items['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir,
						'id'        => $id,
						'categories'    => $categories['results'],
        );


        // load views
        $data['content'] = $this->load->view('account/merchants/items', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	  /**
	 * Add start item
     */

	function start_add_item($id = NULL)
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
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset, $filters, $sort, $dir, $id, $user['username']);
		
    $this->form_validation->set_rules('name', lang('users invoices name'), 'required|max_length[100]|min_length[3]');
		$this->form_validation->set_rules('category_id', lang('users shops item_category'), 'required|numeric');
		$this->form_validation->set_rules('availability', lang('users shops availability'), 'required|numeric');
		$this->form_validation->set_rules('price', lang('users shops price'), 'required|trim|numeric|greater_than[0]');
		$this->form_validation->set_rules('currency', lang('users trans cyr'), 'required|trim|in_list[debit_base,debit_extra1,debit_extra2,debit_extra3,debit_extra4,debit_extra5]');
		$this->form_validation->set_rules('about', lang('users invoices name'), 'required|max_length[3000]|min_length[3]');
		$this->form_validation->set_rules('download_link', lang('users shops item_link'), 'required|max_length[300]|min_length[3]|valid_url');
    
    if ($this->form_validation->run() == TRUE)
    {
			
			$config['upload_path']          = ''.$_SERVER['DOCUMENT_ROOT'].'/upload/items/img';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 40000; // 5mb
			$config['encrypt_name']         = TRUE;
			$config['remove_spaces']        = TRUE;
			
			$this->load->library('upload', $config);
			
			if (! $this->upload->do_upload('img')) {
				
				$img = "default.png";
				
			} else {
				
				$img = $this->upload->data('file_name');
				
			}
			
			$name = $this->input->post("name", TRUE);
			$about = $this->input->post("about", TRUE);
			$category = $this->input->post("category_id", TRUE);
			$merchant_id = $id;
			$availability = $this->input->post("availability", TRUE);
			$price = $this->input->post("price", TRUE);
			$download_link = $this->input->post("download_link", TRUE);
			$currency = $this->input->post("currency", TRUE);
			
			$item = $this->merchants_model->add_item(array(
				"name"       => $name,
				"about"       => $about,
				"category_id"       => $category,
				"merchant_id"       => $id,
				"availability"       => $availability,
				"img"       => $img,
				"download_link"       => $download_link,
				"status"       => "1",
				"user"       => $user['username'],
				"price"       => $price,
				"currency"       => $currency,
				)
			);
			
			$this->session->set_flashdata('message', lang('users shops item_success'));
			// return to list and display message
      redirect(site_url('account/merchants/items/'.$id.''));
			
			
		} else {
			
			$this->session->set_flashdata('error', lang('users shops item_fail'));
			// return to list and display message
      redirect(site_url('account/merchants/items/'.$id.''));
			
		}
		
	}
	
	function add_item($id = NULL)
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
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset, $filters, $sort, $dir, $id, $user['username']);
		
		
		// setup page header data
        $this->set_title(sprintf(lang('users shops merchant'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
					'user'              => $user,
					'categories'    => $categories['results'],
					'total'      => $categories['total'],
					'id'      => $id,
        );

        // load views
        $data['content'] = $this->load->view('account/merchants/add_item', $content_data, TRUE);
        $this->load->view($this->template, $data);
		
	}
	
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
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item['user'] != $user['username']) {
			
			redirect($this->_redirect_url);
			
		}
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset, $filters, $sort, $dir, $item['merchant_id'], $user['username']);
		
		
		// setup page header data
        $this->set_title(sprintf(lang('users shops merchant'), $this->settings->site_name));

        $data = $this->includes;
		
        // set content data
        $content_data = array(
					'user'              => $user,
					'categories'    => $categories['results'],
					'total'      => $categories['total'],
					'id'      => $id,
					'item'      => $item,
        );

        // load views
        $data['content'] = $this->load->view('account/merchants/edit_item', $content_data, TRUE);
        $this->load->view($this->template, $data);
		
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
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item['user'] != $user['username']) {
			
			redirect($this->_redirect_url);
			
		}
		
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
					"name"       => $name,
					"about"       => $about,
					"category_id"       => $category,
					"merchant_id"       => $merchant_id,
					"availability"       => $availability,
					"img"       => $img,
					"download_link"       => $download_link,
					"status"       => $status,
					"user"       => $user['username'],
					"price"       => $price,
					"currency"       => $currency,
				)
			);
			
			$this->session->set_flashdata('message', lang('users shops item_edit_success'));
			// return to list and display message
      redirect(site_url('account/merchants/items/'.$merchant_id.''));
			
			
		} else {
			
			$this->session->set_flashdata('error', lang('users shops item_edit_fail'));
			// return to list and display message
      redirect(site_url('account/merchants/edit_item/'.$item['id'].''));
			
		}
		
	}
	
		    /**
	 * Default
     */
	function merchant_categories($id = NULL)
	{
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }

		
		$user = $this->users_model->get_user($this->user['id']);
		
		// get parameters
    $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
    $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
    $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
    $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
		
		$merchant = $this->merchants_model->get_user_merchant($id, $user['username']);
		
		$categories = $this->merchants_model->get_select_merchant_categories($offset, $filters, $sort, $dir, $merchant['id'], $user['username']);
		
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL_2 . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $categories['total'],
			'per_page'   => $limit
		));
		
		// setup page header data
    $this->set_title( lang('users shops merchant') );

    $data = $this->includes;
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL_2,
            'categories'    => $categories['results'],
            'total'      => $categories['total'],
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir,
						'id'        => $id
        );


        // load views
    $data['content'] = $this->load->view('account/merchants/categories', $content_data, TRUE);
		$this->load->view($this->template, $data);
		
	}
	
	/**
	 * Delite merchant
     */
	function del_merchant_categories($id = NULL)
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$shop = $this->merchants_model->get_user_merchant_category($id);
		
		if ($user['username'] == $shop['user']) {
			
			$delete = $this->merchants_model->delete_category_user_merchant($id);

			$this->session->set_flashdata('message', lang('users shops category_del_success'));
			redirect(site_url('account/merchants'));
			
		} else {
			
			// return to list and display message
			$this->session->set_flashdata('error', lang('users shops category_fail'));
      redirect(site_url('account/merchants'));
			
		}
		
	}
	
	/**
	 * Delite merchant
     */
	function del_items($id = NULL)
	{
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$item = $this->merchants_model->get_item($id);
		
		if ($item['user'] == $user['username']) {
			
			$delete = $this->merchants_model->delete_user_items($id);

			$this->session->set_flashdata('message', lang('users shops item_del_success'));
			redirect(site_url('account/merchants/items/'.$item['merchant_id'].''));
			
		} else {
			
			redirect($this->_redirect_url);
			
		}
		
	}
	
			    /**
	 * Add merchant
     */
	function add_merchant_categories($merchant = NULL)
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$shop = $this->merchants_model->get_merchant($merchant);
		
		// make sure we have a numeric id
    if (is_null($merchant) OR ! is_numeric($merchant))
    {
       redirect($this->_redirect_url);
    }
		
		foreach ($this->session->languages as $language_key=>$language_name)
    {
			$this->form_validation->set_rules("name[" . $language_key . "]", lang('users invoices name'), 'trim');
    	$this->form_validation->set_rules('status', lang('users trans status'), 'required|in_list[1,2]|numeric');
    }
		
		if ($this->form_validation->run() == TRUE && $user['username'] == $shop['user'])
		{
			
			// save the changes
      $saved = $this->merchants_model->add_merchant_category($this->security->xss_clean($this->input->post()), $user['username'], $merchant);
			
			if ($saved)
      {
      	$this->session->set_flashdata('message', lang('users shops category_success'));
      }
      else
      {
				$this->session->set_flashdata('error', lang('users shops category_fail'));
      }
			

      // return to list and display message
      redirect(site_url('account/merchants/merchant_categories/'.$merchant.''));
			
			
		} else {
			
			// return to list and display message
			$this->session->set_flashdata('error', lang('users shops category_fail'));
      redirect(site_url('account/merchants/merchant_categories/'.$merchant.''));
			
		}
		
	}
	
		    /**
	 * Edit merchant
     */
	function edit_merchant_categories($merchant = NULL)
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		$shop = $this->merchants_model->get_merchant($merchant);
		
		// make sure we have a numeric id
    if (is_null($merchant) OR ! is_numeric($merchant))
    {
       redirect($this->_redirect_url);
    }
		
		foreach ($this->session->languages as $language_key=>$language_name)
    {
			$this->form_validation->set_rules("name[" . $language_key . "]", lang('users invoices name'), 'trim');
			$this->form_validation->set_rules('id', lang('users trans id'), 'required|numeric');
    	$this->form_validation->set_rules('status', lang('users trans status'), 'required|in_list[1,2]|numeric');
    }
		
		if ($this->form_validation->run() == TRUE && $user['username'] == $shop['user'])
		{
			
			// save the changes
      $saved = $this->merchants_model->edit_merchant_category($this->security->xss_clean($this->input->post()));
			
			if ($saved)
      {
      	$this->session->set_flashdata('message', lang('users shops category_success'));
      }
      else
      {
				$this->session->set_flashdata('error', lang('users shops category_fail'));
      }
			

      // return to list and display message
      redirect(site_url('account/merchants/merchant_categories/'.$merchant.''));
			
			
		} else {
			
			// return to list and display message
			$this->session->set_flashdata('error', lang('users shops category_fail'));
      redirect(site_url('account/merchants/merchant_categories/'.$merchant.''));
			
		}
		
	}
	
  
   /**
    * Edit merchant
    */
	function settings($id = NULL)
  {
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
       redirect($this->_redirect_url);
    }
    // get parameters
    $offset = "0";
    $sort   = "id";
    $dir    = "desc";
    
		$user = $this->users_model->get_user($this->user['id']);
			
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $merchant = $this->merchants_model->get_user_merchant($id, $user['username']);

        // if empty results, return to list
        if ( ! $merchant)
        {
            redirect($this->_redirect_url);
        }
    
        $categories = $this->merchants_model->get_select_categories($offset, $filters, $sort, $dir);
		
				$this->form_validation->set_rules('success_link', lang('users shops merchant_success'), 'max_length[100]');
        $this->form_validation->set_rules('fail_link', lang('users shops merchant_fail'), 'max_length[100]');
        $this->form_validation->set_rules('password', lang('users shops merchant_password'), 'required|min_length[10]|max_length[100]');
        $this->form_validation->set_rules('show_category', lang('admin invoices description'), 'required|in_list[0,1]');
				$this->form_validation->set_rules('payeer_fee', lang('admin invoices description'), 'required|in_list[0,1]');
				$this->form_validation->set_rules('test_mode', lang('admin invoices description'), 'required|in_list[0,1]');
    
        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->merchants_model->edit_user_merchant($this->security->xss_clean($this->input->post()));

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('users shops merchant_update_success'));
            }
            else
            {
				        $this->session->set_flashdata('error', lang('users shops merchant_update_fail'));
            }

            // return to list and display message
            redirect(site_url("account/merchants"));
        }
    
        
        // setup page header data
        $this->set_title( lang('users shops merchant') );

        $data = $this->includes;

        // set content data
        $content_data = array(
          'this_url'   		=> THIS_URL,
          'user'              => $user,
          'cancel_url'        => $this->_redirect_url,
          'merchant'      => $merchant,
          'categories'      => $categories['results'],
          'total'      => $categories['total'],
        );

        // load views
        $data['content'] = $this->load->view('account/merchants/settings', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
		 /**
    * Add merchant
    */
	function add()
    {
    // get parameters
    $offset = "0";
    $sort   = "id";
    $dir    = "desc";
    
		$user = $this->users_model->get_user($this->user['id']);
			
    if ($user['verify_status'] == 2) {
			
			$categories = $this->merchants_model->get_select_categories($offset, $filters, $sort, $dir);
		
				$total = $categories['total'];
				
				$this->form_validation->set_rules('name', lang('users invoices name'), 'required|max_length[100]');
				$this->form_validation->set_rules('success_link', lang('users shops merchant_success'), 'required|max_length[100]');
        $this->form_validation->set_rules('fail_link', lang('users shops merchant_fail'), 'required|max_length[100]');
				$this->form_validation->set_rules('link', lang('users merchants url'), 'required|max_length[100]');
				$this->form_validation->set_rules('status_link', lang('users merchants ipn'), 'required|max_length[100]');
        $this->form_validation->set_rules('password', lang('users shops merchant_password'), 'required|min_length[10]|max_length[100]');
				$this->form_validation->set_rules('category', lang('users shops categories'), 'required|numeric|callback__check_category[]');
        $this->form_validation->set_rules('show_category', lang('admin invoices description'), 'required|in_list[0,1]');
				$this->form_validation->set_rules('payeer_fee', lang('admin invoices description'), 'required|in_list[0,1]');
				$this->form_validation->set_rules('test_mode', lang('admin invoices description'), 'required|in_list[0,1]');
				$this->form_validation->set_rules('comment', lang('users merchants comment'), 'max_length[100]');
				$this->form_validation->set_rules('note_payment', lang('users merchants comment'), 'max_length[100]');
    
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

							$logo = "shop.png";

						} else {

							$logo = $this->upload->data('file_name');

						}
            // save the changes
            $saved = $this->merchants_model->add_user_merchant($this->security->xss_clean($this->input->post()), $logo, $user['username']);

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('users shops merchant_update_success'));
            }
            else
            {
				        $this->session->set_flashdata('error', lang('users shops merchant_update_fail'));
            }

            // return to list and display message
            redirect(site_url("account/merchants"));
        }
    
        
        // setup page header data
        $this->set_title( lang('users shops merchant') );

        $data = $this->includes;

        // set content data
        $content_data = array(
          'this_url'   		=> THIS_URL,
          'user'              => $user,
          'cancel_url'        => $this->_redirect_url,
          'categories'      => $categories['results'],
          'total'      => $categories['total'],
        );

        // load views
        $data['content'] = $this->load->view('account/merchants/add', $content_data, TRUE);
        $this->load->view($this->template, $data);
			
		} else {
			
			// return to list and display message
			$this->session->set_flashdata('error', lang('users shops noa_add_merchant'));
      redirect(site_url("account/merchants"));
			
		}
		
        
    }
	
	function merchant_orders($id = NULL)
	{
		$user = $this->users_model->get_user($this->user['id']);
		
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
    	redirect($this->_redirect_url);
    }

    // get the data
    $merchant = $this->merchants_model->get_user_merchant($id, $user['username']);

    // if empty results, return to list
    if ( ! $merchant)
    {
    	redirect($this->_redirect_url);
    }
		
		$coreect_url = base_url('account/merchants/merchant_orders/'.$id.'');
		
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
		
		if ($this->input->get('code', TRUE))
    {
      $code_xss = $this->security->xss_clean($this->input->get('code'));
			$code_string = htmlentities($code_xss, ENT_QUOTES, "UTF-8");
			$filters['code'] = $code_string;
    }
		
		if ($this->input->get('id_transaction', TRUE))
    {
      $id_transaction_xss = $this->security->xss_clean($this->input->get('id_transaction'));
			$id_transaction_string = htmlentities($id_transaction_xss, ENT_QUOTES, "UTF-8");
			$filters['id_transaction'] = $id_transaction_string;
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
                redirect($coreect_url);
            } else {

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
							
								if ($this->input->post('id_transaction'))
                {
                    $filter .= "&id_transaction=" . $this->input->post('id_transaction', TRUE);
                }
							
								if ($this->input->post('user'))
                {
                    $filter .= "&user=" . $this->input->post('user', TRUE);
                }

                // redirect using new filter(s)
                redirect($coreect_url . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->orders_model->get_merchant_orders($limit, $offset, $filters, $sort, $dir, $merchant['id']);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users shops merchant'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$history = $this->orders_model->get_merchant_orders($limit, $offset, $filters, $sort, $dir, $merchant['id']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => $coreect_url . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $history['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
					'merchant'       => $merchant,
            'this_url'   => $coreect_url,
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
        $data['content'] = $this->load->view('account/merchants/merchant_orders', $content_data, TRUE);
		$this->load->view($this->template, $data);
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