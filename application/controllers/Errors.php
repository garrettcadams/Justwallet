<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Just Wallet
 * Copyright (c), Just Didigital Tech
 * Author code Anna Kantemirova and Sergey Plaxin
 * Site developer http://justigniter.io/
 * License https://codecanyon.net/licenses/terms/regular
**/

class Errors extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model('pages_model');
        // disable the profiler
        $this->output->enable_profiler(FALSE);
    }


    /**
     * Custom 404 page
     */
    function error404()
    {
        // setup page header data
        $this->set_title(sprintf(lang('core button help'), $this->settings->site_name));

        $data = $this->includes;
        
        $page = $this->pages_model->get_page(8);

        $content = (@unserialize($page['content']) !== FALSE) ? unserialize($page['content']) : $page['content'];

        // set content data
        $content_data = array(
            'content' => $content[$this->session->language]
        );

        // load views
        $data['content'] = $this->load->view('error404', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

}
