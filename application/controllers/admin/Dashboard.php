<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language files
        $this->lang->load('dashboard');
				$this->load->model('support_model');
				$this->load->model('verification_model');
				$this->load->model('users_model');
				$this->load->model('transactions_model');
				$this->load->model('disputes_model');
				$this->load->model('merchants_model');
				$this->load->model('events_model');
				$this->load->model('vouchers_model');
				$this->load->library('notice');
				$this->load->library('currencys');
			
				$this->lang->load('users');
    }


    /**
     * Dashboard
     */
    function index()
    {
			
			$total_user = $this->users_model->total_users_deposit();
			
			$total_transactions = $this->transactions_model->total_dash_transactions();
			
			$total_disputes = $this->disputes_model->total_dash_disputes();
			
			$total_support = $this->support_model->total_dash_support();
			
			$total_merchants = $this->merchants_model->total_dash_merchants();
			
			$total_vouchers = $this->vouchers_model->total_dash_vouchers();
			
			$transactions = $this->transactions_model->get_pending_dash();
			
			$disputes = $this->disputes_model->get_pending_dash();
			
			$tickets = $this->support_model->get_pending_dash();
			
			$verification = $this->verification_model->get_pending_dash();
			
			$merchants = $this->merchants_model->get_pending_dash();
			
        // setup page header data
		$this
			->add_js_theme('dashboard_i18n.js', TRUE)
			->set_title(lang('admin title admin'));
			  
			$data = $this->includes;
			
			 $content_data = array(
					'total_user'       => $total_user,
				 	'total_transactions'       => $total_transactions,
				 	'total_disputes'       => $total_disputes,
				 	'total_support'       => $total_support,
				 	'total_merchants'       => $total_merchants,
				 	'total_vouchers'       => $total_vouchers,
				 	'transactions'       => $transactions,
				 	'disputes'       => $disputes,
				 	'tickets'       => $tickets,
				 	'verification'       => $verification,
				 	'merchants'       => $merchants,
       );

        // load views
        $data['content'] = $this->load->view('admin/dashboard', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

}
