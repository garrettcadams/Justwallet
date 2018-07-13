<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Private Class - used for all private pages
 */
class Private_Controller extends MY_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
      
        $this->load->library('currencys');
        $this->load->library('notice');
        $this->load->library('sms');
        $this->load->model('invoices_model');
        $this->load->model('transactions_model');
        $this->load->model('users_model');
        $this->load->model('cart_model');
        $this->load->model('support_model');
        $this->load->model('template_model');

        // must be logged in
        if ( ! $this->user)
        {
            if (current_url() != base_url())
            {
                // store requested URL to session - will load once logged in
                $data = array('redirect' => current_url());
                $this->session->set_userdata($data);
            }

            redirect('login');
        }
      
        $user = $this->users_model->get_user($this->user['id']);
      
        if ($user['login_status'] == 1) {
          
          redirect(base_url('user/authentication'));
          
        }

        // prepare theme name
        $this->settings->theme = strtolower($this->config->item('account_theme'));

        // set up global header data
        $this
            ->add_css_theme("{$this->settings->theme}.css")
            ->add_js_theme("{$this->settings->theme}_i18n.js", TRUE);

        // declare main template
        $this->template = "../../{$this->settings->themes_folder}/{$this->settings->theme}/template.php";
    }

}
