<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language file
        $this->lang->load('welcome');
				$this->load->model('pages_model');
    }


    /**
	 * Default
     */
	function index()
	{
        // setup page header data
        $this->set_title(sprintf(lang('core button help'), $this->settings->site_name));

        $data = $this->includes;
		
				$page = $this->pages_model->get_page(4);

        $content = (@unserialize($page['content']) !== FALSE) ? unserialize($page['content']) : $page['content'];

        // set content data
        $content_data = array(
						'content' => $content[$this->session->language]
        );

        // load views
        $data['content'] = $this->load->view('help', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

}
