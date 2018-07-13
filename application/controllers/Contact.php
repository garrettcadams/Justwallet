<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Public_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language file
        $this->lang->load('contact');

        // load the model file
        $this->load->model('contact_model');

        // load the captcha helper
        $this->load->helper('captcha');
    }


    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/


    /**
     * Default
     */
    function index()
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('name', lang('contact input name'), 'required|trim|max_length[64]');
        $this->form_validation->set_rules('email', lang('contact input email'), 'required|trim|valid_email|min_length[10]|max_length[256]');
        $this->form_validation->set_rules('title', lang('contact input title'), 'required|trim|max_length[128]');
        $this->form_validation->set_rules('message', lang('contact input message'), 'required|trim|min_length[10]');

        if ($this->form_validation->run() == TRUE)
        {
          //your site secret key
						$secret = $this->settings->google_secret;
						//get verify response data
						$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
						$responseData = json_decode($verifyResponse);
          
            if($responseData->success) {
              
              // attempt to save and send the message
              $post_data = $this->security->xss_clean($this->input->post());
              $saved_and_sent = $this->contact_model->save_and_send_message($post_data, $this->settings);

              if ($saved_and_sent)
              {
                  // redirect to home page
                  $this->session->set_flashdata('message', sprintf(lang('contact msg send_success'), $this->input->post('name', TRUE)));
                  redirect(base_url());
              }
              else
              {
                  // stay on contact page
                  $this->error = sprintf(lang('contact error send_failed'), $this->input->post('name', TRUE));
              }
              
            } else {
              
              $this->session->set_flashdata('error', lang('core error captcha_not_valid'));
							redirect(site_url("contact"));
              
            }
        }


        // store captcha image
        $this->contact_model->save_captcha($captcha_data);

        // setup page header data
        $this->set_title(lang('contact title'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'captcha_image' => $captcha['image']
        );

        // load views
        $data['content'] = $this->load->view('contact/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/


    /**
     * Verifies correct CAPTCHA value
     *
     * @param  string $captcha
     * @return string|boolean
     */
    function _check_captcha($captcha)
    {
        $verified = $this->contact_model->verify_captcha($captcha);

        if ($verified == FALSE)
        {
            $this->form_validation->set_message('_check_captcha', lang('contact error captcha'));
            return FALSE;
        }
        else
        {
            return $captcha;
        }
    }

}
