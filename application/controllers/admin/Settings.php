<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language files
        $this->lang->load('settings');
				$this->load->model('support_model');
				$this->load->model('verification_model');
				$this->load->model("currencys_model");
				$this->load->library('currencys');
				$this->load->library('notice');
				$this->load->library('fixer');
			
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/settings/withdrawal'));
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
     * Settings Editor
     */
    function index()
    {
        // get settings
        $settings = $this->settings_model->get_settings();

        // form validations
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        foreach ($settings as $setting)
        {
            if ($setting['validation'])
            {
                if ($setting['translate'])
                {
                    // setup a validation for each translation
                    foreach ($this->session->languages as $language_key=>$language_name)
                    {
                        $this->form_validation->set_rules($setting['name'] . "[" . $language_key . "]", $setting['label'] . " [" . $language_name . "]", $setting['validation']);
                    }
                }
                else
                {
                    // single validation
                    $this->form_validation->set_rules($setting['name'], $setting['label'], $setting['validation']);
                }
            }
        }

        if ($this->form_validation->run() == TRUE)
        {
            $user = $this->session->userdata('logged_in');

            // save the settings
            $saved = $this->settings_model->save_settings($this->input->post(), $user['id']);

            if ($saved)
            {
                $this->session->set_flashdata('message', lang('admin settings msg save_success'));
                // reload the new settings
                $settings = $this->settings_model->get_settings();
                foreach ($settings as $setting)
                {
                    $this->settings->{$setting['name']} = @unserialize($setting['value']);
                }
            }
            else
            {
                $this->session->set_flashdata('error', lang('admin settings error save_failed'));
            }

            // reload the page
            redirect('admin/settings');
        }

        // setup page header data
		$this
			->add_css_theme('summernote.css')
			->add_js_theme('summernote.min.js')
			->add_js_theme('settings_i18n.js', TRUE)
			->set_title(lang('admin settings title'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'settings'   => $settings,
            'cancel_url' => "/admin",
        );

        // load views
        $data['content'] = $this->load->view('admin/settings/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
		/**
     * Withdrawal methods
     */
    function withdrawal()
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
			$methods = $this->settings_model->get_all_withdrawal($limit, $offset, $filters, $sort, $dir);
					
        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admin settings withdrawal') );
		
        $data = $this->includes;
			
		// get list
		$methods = $this->settings_model->get_all_withdrawal($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $methods['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'methods'    => $methods['results'],
            'total'      => $methods['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/settings/withdrawal', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
			/**
     * Edit tickets
     */
	
	function edit_withdrawal($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $method = $this->settings_model->get_win_method($id);

        // if empty results, return to list
        if ( ! $method)
        {
            redirect($this->_redirect_url);
        }

			$this->form_validation->set_rules('name', lang('admin settings name'), 'required');
			$this->form_validation->set_rules('terms', lang('admin settings terms'), 'required');
			$this->form_validation->set_rules('status', lang('admin user status'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('fee_fix', lang('admin settings fix_fee'), 'required|numeric');
			$this->form_validation->set_rules('fee', lang('admin settings fee'), 'required|numeric');
			$this->form_validation->set_rules('start_verify', lang('admin settings initial'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('standart_verify', lang('admin settings standart'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('expanded_verify', lang('admin settings extended'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_base', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra1', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra2', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra3', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra4', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra5', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('minimum_debit_base', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_base', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra1', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra1', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra2', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra2', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra3', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra3', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra4', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra4', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra5', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra5', lang('admin withdrawal maximum'), 'required|numeric');

            if ($this->form_validation->run() == TRUE)
            {
                // save the changes
                $saved = $this->settings_model->edit_win_methode($this->input->post());

                if ($saved)
                {
                    $this->session->set_flashdata('message', lang('admin settings success'));
                }
                else
                {
    				$this->session->set_flashdata('error', lang('admin settings error'));
                }

                // return to list and display message
                redirect($this->_redirect_url);
            }

        // setup page header data
        $this->set_title( lang('admin settings withdrawal') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   	=> THIS_URL,
            'cancel_url'    => $this->_redirect_url,
            'method'       => $method,
            'method_id'     => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/settings/edit_withdrawal', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	
		 /**
    * Currency
    */
    function currencys()
    {
        // get currencys
        $currencys = $this->currencys_model->get_currencys();

        // setup page header data
		 $this
			->set_title(lang('admin settings currency'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'currencys'   	=> $currencys,
            'cancel_url' 	=> "/admin",
        );

        // load views
        $data['content'] = $this->load->view('admin/settings/currencys', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	/**
    * Save settings currencys
    */
	function update_currencys()
	{
		$base_name = $this->input->post("base_name");
		$base_code = $this->input->post("base_code");
		$extra1_check = intval($this->input->post("extra1_check"));
		$extra1_name = $this->input->post("extra1_name");
		$extra1_code = $this->input->post("extra1_code");
		$extra1_rate = abs($this->input->post("extra1_rate"));
		$extra2_check = intval($this->input->post("extra2_check"));
		$extra2_name = $this->input->post("extra2_name");
		$extra2_code = $this->input->post("extra2_code");
		$extra2_rate = abs($this->input->post("extra2_rate"));
		$extra3_check = intval($this->input->post("extra3_check"));
		$extra3_name = $this->input->post("extra3_name");
		$extra3_code = $this->input->post("extra3_code");
		$extra3_rate = abs($this->input->post("extra3_rate"));
		$extra4_check = intval($this->input->post("extra4_check"));
		$extra4_name = $this->input->post("extra4_name");
		$extra4_code = $this->input->post("extra4_code");
		$extra4_rate = abs($this->input->post("extra4_rate"));
		$extra5_check = intval($this->input->post("extra5_check"));
		$extra5_name = $this->input->post("extra5_name");
		$extra5_code = $this->input->post("extra5_code");
		$extra5_rate = abs($this->input->post("extra5_rate"));
		$fee = $this->input->post("fee");
		$fee_fix = $this->input->post("fee_fix");
		$api_extra1 = $this->input->post("api_extra1");
		$api_extra2 = $this->input->post("api_extra2");
		$api_extra3 = $this->input->post("api_extra3");
		$api_extra4 = $this->input->post("api_extra4");
		$api_extra5 = $this->input->post("api_extra5");
		

		// update
		$this->currencys_model->updateCurrencys(
			array(
				"base_name" 	=> $base_name,
				"base_code" 	=> $base_code,
				"extra1_check" 	=> $extra1_check,
				"extra1_name" 	=> $extra1_name,
				"extra1_code" 	=> $extra1_code,
				"extra1_rate" 	=> $extra1_rate,
				"extra2_check" 	=> $extra2_check,
				"extra2_name" 	=> $extra2_name,
				"extra2_code" 	=> $extra2_code,
				"extra2_rate" 	=> $extra2_rate,
				"extra3_check" 	=> $extra3_check,
				"extra3_name" 	=> $extra3_name,
				"extra3_code" 	=> $extra3_code,
				"extra3_rate" 	=> $extra3_rate,
				"extra4_check" 	=> $extra4_check,
				"extra4_name" 	=> $extra4_name,
				"extra4_code" 	=> $extra4_code,
				"extra4_rate" 	=> $extra4_rate,
				"extra5_check" 	=> $extra5_check,
				"extra5_name" 	=> $extra5_name,
				"extra5_code" 	=> $extra5_code,
				"extra5_rate" 	=> $extra5_rate,
				"fee" 	=> $fee,
				"fee_fix" 	=> $fee_fix,
				"api_extra1" 	=> $api_extra1,
				"api_extra2" 	=> $api_extra2,
				"api_extra3" 	=> $api_extra3,
				"api_extra4" 	=> $api_extra4,
				"api_extra5" 	=> $api_extra5,
			)
		);
		
		$this->session->set_flashdata('message', lang('admins currency msg save_success'));
		redirect(site_url("admin/settings/currencys"));

	}
	
			/**
     * Deposit methods
     */
    function deposit()
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
			$methods = $this->settings_model->get_all_deposit($limit, $offset, $filters, $sort, $dir);
					
        }
			
		// save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
        // setup page header data
		$this
			->add_js_theme("currency_i18n.js", TRUE )
			->set_title( lang('admin title deposit_settings') );
		
        $data = $this->includes;
			
		// get list
		$methods = $this->settings_model->get_all_deposit($limit, $offset, $filters, $sort, $dir);
			
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $methods['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'methods'    => $methods['results'],
            'total'      => $methods['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/settings/deposit', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
		/**
     * Edit tickets
     */
	
	function edit_deposit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $method = $this->settings_model->get_dep_method($id);

        // if empty results, return to list
        if ( ! $method)
        {
            redirect($this->_redirect_url);
        }
		
			$this->form_validation->set_rules('name', lang('admin settings name'), 'required');
			$this->form_validation->set_rules('status', lang('admin user status'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('fee_fix', lang('admin settings fix_fee'), 'required|numeric');
			$this->form_validation->set_rules('fee', lang('admin settings fee'), 'required|numeric');
			$this->form_validation->set_rules('start_verify', lang('admin settings initial'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('standart_verify', lang('admin settings standart'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('expanded_verify', lang('admin settings extended'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_base', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra1', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra2', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra3', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra4', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('debit_extra5', lang('admin settings currency'), 'required|in_list[0,1]');
			$this->form_validation->set_rules('minimum_debit_base', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_base', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra1', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra1', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra2', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra2', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra3', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra3', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra4', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra4', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('minimum_debit_extra5', lang('admin withdrawal minimum'), 'required|numeric');
			$this->form_validation->set_rules('maximum_debit_extra5', lang('admin withdrawal maximum'), 'required|numeric');
			$this->form_validation->set_rules('ac_debit_base', lang('admin deposit account_pp'), 'required');
			$this->form_validation->set_rules('ac_debit_extra1', lang('admin deposit account_pp'), 'required');
			$this->form_validation->set_rules('ac_debit_extra2', lang('admin deposit account_pp'), 'required');
			$this->form_validation->set_rules('ac_debit_extra3', lang('admin deposit account_pp'), 'required');
			$this->form_validation->set_rules('ac_debit_extra4', lang('admin deposit account_pp'), 'required');
			$this->form_validation->set_rules('ac_debit_extra5', lang('admin deposit account_pp'), 'required');
			$this->form_validation->set_rules('api_value1', lang('admin deposit api_value_1'), 'required');
			$this->form_validation->set_rules('api_value2', lang('admin deposit api_value_2'), 'required');

            if ($this->form_validation->run() == TRUE)
            {
                // save the changes
                $saved = $this->settings_model->edit_dep_methode($this->input->post());

                if ($saved)
                {
                    $this->session->set_flashdata('message', lang('admin settings success'));
                }
                else
                {
    				$this->session->set_flashdata('error', lang('admin settings error'));
                }

                redirect(site_url("admin/settings/deposit"));
            }

        // setup page header data
        $this->set_title( lang('admin title deposit_settings') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   	=> THIS_URL,
            'cancel_url'    => $this->_redirect_url,
            'method'       => $method,
            'method_id'     => $id
        );

        // load views
        $data['content'] = $this->load->view('admin/settings/edit_deposit', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

}
