<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profit extends Admin_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language files
        $this->lang->load('dashboard');
				$this->load->model('transactions_model');
				$this->load->library('notice');
        $this->load->library('currencys');
      
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/profit'));
    }
  
  /**
     * Main page
     */
    function index()
    {
      
      // get filters
      $filters = array();
      
      if ($this->input->get('start_date'))
      {
				$start_date_xss = $this->security->xss_clean($this->input->get('start_date'));
				$start_date_replace = htmlentities($start_date_xss, ENT_QUOTES, "UTF-8");
        $filters['start_date'] = $start_date_replace;
      }
      
      if ($this->input->get('end_date'))
      {
				$end_date_xss = $this->security->xss_clean($this->input->get('end_date'));
				$end_date_replace = htmlentities($end_date_xss, ENT_QUOTES, "UTF-8");
        $filters['end_date'] = $end_date_replace;
      }
      
      // build filter string
      $filter = "";
      foreach ($filters as $key => $value)
      {
        $filter .= "&{$key}={$value}";
      }
      
      // save the current url to session for returning
      $this->session->set_userdata(REFERRER, THIS_URL . "?{$filter}");
      
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

                if ($this->input->post('start_date'))
                {
                    $filter .= "&start_date=" . $this->input->post('start_date', TRUE);
                }
								if ($this->input->post('end_date'))
                {
                    $filter .= "&end_date=" . $this->input->post('end_date', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?{$filter}");
            }
        }
      
      // summary fee report USD
      $select_sum_withd_fee_debit_base = $this->transactions_model->select_sum_withd_fee_debit_base($filters);
      $select_sum_transfer_fee_debit_base = $this->transactions_model->select_sum_transfer_fee_debit_base($filters);
      $select_sum_exchange_fee_debit_base = $this->transactions_model->select_sum_exchange_fee_debit_base($filters);
      $select_sum_sci_fee_debit_base = $this->transactions_model->select_sum_sci_fee_debit_base($filters);
      
      $select_sum_withd_fee_debit_extra1 = $this->transactions_model->select_sum_withd_fee_debit_extra1($filters);
      $select_sum_transfer_fee_debit_extra1 = $this->transactions_model->select_sum_transfer_fee_debit_extra1($filters);
      $select_sum_exchange_fee_debit_extra1 = $this->transactions_model->select_sum_exchange_fee_debit_extra1($filters);
      $select_sum_sci_fee_debit_extra1 = $this->transactions_model->select_sum_sci_fee_debit_extra1($filters);
      
      $select_sum_withd_fee_debit_extra2 = $this->transactions_model->select_sum_withd_fee_debit_extra2($filters);
      $select_sum_transfer_fee_debit_extra2 = $this->transactions_model->select_sum_transfer_fee_debit_extra2($filters);
      $select_sum_exchange_fee_debit_extra2 = $this->transactions_model->select_sum_exchange_fee_debit_extra2($filters);
      $select_sum_sci_fee_debit_extra2 = $this->transactions_model->select_sum_sci_fee_debit_extra2($filters);
      
      $select_sum_withd_fee_debit_extra3 = $this->transactions_model->select_sum_withd_fee_debit_extra3($filters);
      $select_sum_transfer_fee_debit_extra3 = $this->transactions_model->select_sum_transfer_fee_debit_extra3($filters);
      $select_sum_exchange_fee_debit_extra3 = $this->transactions_model->select_sum_exchange_fee_debit_extra3($filters);
      $select_sum_sci_fee_debit_extra3 = $this->transactions_model->select_sum_sci_fee_debit_extra3($filters);
      
      $select_sum_withd_fee_debit_extra4 = $this->transactions_model->select_sum_withd_fee_debit_extra4($filters);
      $select_sum_transfer_fee_debit_extra4 = $this->transactions_model->select_sum_transfer_fee_debit_extra4($filters);
      $select_sum_exchange_fee_debit_extra4 = $this->transactions_model->select_sum_exchange_fee_debit_extra4($filters);
      $select_sum_sci_fee_debit_extra4 = $this->transactions_model->select_sum_sci_fee_debit_extra4($filters);
      
      $select_sum_withd_fee_debit_extra5 = $this->transactions_model->select_sum_withd_fee_debit_extra5($filters);
      $select_sum_transfer_fee_debit_extra5 = $this->transactions_model->select_sum_transfer_fee_debit_extra5($filters);
      $select_sum_exchange_fee_debit_extra5 = $this->transactions_model->select_sum_exchange_fee_debit_extra5($filters);
      $select_sum_sci_fee_debit_extra5 = $this->transactions_model->select_sum_sci_fee_debit_extra5($filters);
      // summary fee report
      
      // total transactions deposits
      $total_deposits_confirm = $this->transactions_model->total_deposits($filters); /////////////////////////////////////
      $total_deposits_debit_base = $this->transactions_model->total_deposits_debit_base($filters);
      $total_deposits_debit_extra1 = $this->transactions_model->total_deposits_debit_extra1($filters);
      $total_deposits_debit_extra2 = $this->transactions_model->total_deposits_debit_extra2($filters);
      $total_deposits_debit_extra3 = $this->transactions_model->total_deposits_debit_extra3($filters);
      $total_deposits_debit_extra4 = $this->transactions_model->total_deposits_debit_extra4($filters);
      $total_deposits_debit_extra5 = $this->transactions_model->total_deposits_debit_extra5($filters);
      // total transactions deposits
      
      // total transactions withdrawal
      $total_withdrawal_confirm = $this->transactions_model->total_withdrawal($filters);
      $total_withdrawal_debit_base = $this->transactions_model->total_withdrawal_debit_base($filters);
      $total_withdrawal_debit_extra1 = $this->transactions_model->total_withdrawal_debit_extra1($filters);
      $total_withdrawal_debit_extra2 = $this->transactions_model->total_withdrawal_debit_extra2($filters);
      $total_withdrawal_debit_extra3 = $this->transactions_model->total_withdrawal_debit_extra3($filters);
      $total_withdrawal_debit_extra4 = $this->transactions_model->total_withdrawal_debit_extra4($filters);
      $total_withdrawal_debit_extra5 = $this->transactions_model->total_withdrawal_debit_extra5($filters);
      // total transactions withdrawal
      
      // total sum transactions withdrawal
      $total_withdrawal_confirm_debit_base = $this->transactions_model->select_sum_total_withdrawal_debit_base($filters);
      $total_withdrawal_confirm_debit_extra1 = $this->transactions_model->select_sum_total_withdrawal_debit_extra1($filters);
      $total_withdrawal_confirm_debit_extra2 = $this->transactions_model->select_sum_total_withdrawal_debit_extra2($filters);
      $total_withdrawal_confirm_debit_extra3 = $this->transactions_model->select_sum_total_withdrawal_debit_extra3($filters);
      $total_withdrawal_confirm_debit_extra4 = $this->transactions_model->select_sum_total_withdrawal_debit_extra4($filters);
      $total_withdrawal_confirm_debit_extra5 = $this->transactions_model->select_sum_total_withdrawal_debit_extra5($filters);
      // total sum transactions withdrawal
      
      // total fee transactions withdrawal
      $total_withdrawal_fee_confirm_debit_base = $this->transactions_model->select_sum_total_withdrawal_fee_debit_base($filters);
      $total_withdrawal_fee_confirm_debit_extra1 = $this->transactions_model->select_sum_total_withdrawal_fee_debit_extra1($filters);
      $total_withdrawal_fee_confirm_debit_extra2 = $this->transactions_model->select_sum_total_withdrawal_fee_debit_extra2($filters);
      $total_withdrawal_fee_confirm_debit_extra3 = $this->transactions_model->select_sum_total_withdrawal_fee_debit_extra3($filters);
      $total_withdrawal_fee_confirm_debit_extra4 = $this->transactions_model->select_sum_total_withdrawal_fee_debit_extra4($filters);
      $total_withdrawal_fee_confirm_debit_extra5 = $this->transactions_model->select_sum_total_withdrawal_fee_debit_extra5($filters);
      // total fee transactions withdrawal
      
      // total sum transactions
      $total_deposits_confirm_debit_base = $this->transactions_model->select_sum_total_deposits_debit_base($filters);
      $total_deposits_confirm_debit_extra1 = $this->transactions_model->select_sum_total_deposits_debit_extra1($filters);
      $total_deposits_confirm_debit_extra2 = $this->transactions_model->select_sum_total_deposits_debit_extra2($filters);
      $total_deposits_confirm_debit_extra3 = $this->transactions_model->select_sum_total_deposits_debit_extra3($filters);
      $total_deposits_confirm_debit_extra4 = $this->transactions_model->select_sum_total_deposits_debit_extra4($filters);
      $total_deposits_confirm_debit_extra5 = $this->transactions_model->select_sum_total_deposits_debit_extra5($filters);
      // total sum transactions
      
      // total fee transactions
      $total_fee_confirm_debit_base = $this->transactions_model->select_sum_total_fee_debit_base($filters);
      $total_fee_confirm_debit_extra1 = $this->transactions_model->select_sum_total_fee_debit_extra1($filters);
      $total_fee_confirm_debit_extra2 = $this->transactions_model->select_sum_total_fee_debit_extra2($filters);
      $total_fee_confirm_debit_extra3 = $this->transactions_model->select_sum_total_fee_debit_extra3($filters);
      $total_fee_confirm_debit_extra4 = $this->transactions_model->select_sum_total_fee_debit_extra4($filters);
      $total_fee_confirm_debit_extra5 = $this->transactions_model->select_sum_total_fee_debit_extra5($filters);
      // total fee transactions
      
      // deposit method
      $paypal = $this->settings_model->get_dep_method(1);
      $perfect_m = $this->settings_model->get_dep_method(2);
      $advcash = $this->settings_model->get_dep_method(3);
      $payeer = $this->settings_model->get_dep_method(4);
      $skrill = $this->settings_model->get_dep_method(5);
      $paygol = $this->settings_model->get_dep_method(6);
      $swift = $this->settings_model->get_dep_method(7);
      $local_bank = $this->settings_model->get_dep_method(8);
      $coinpayments = $this->settings_model->get_dep_method(9);
      $blockchain = $this->settings_model->get_dep_method(10);
      // deposit method
      
      // method transactions
      $total_method_1 = $this->transactions_model->select_sum_total_method($paypal['name'], $filters);
      $total_method_2 = $this->transactions_model->select_sum_total_method($perfect_m['name'], $filters);
      $total_method_3 = $this->transactions_model->select_sum_total_method($advcash['name'], $filters);
      $total_method_4 = $this->transactions_model->select_sum_total_method($payeer['name'], $filters);
      $total_method_5 = $this->transactions_model->select_sum_total_method($skrill['name'], $filters);
      $total_method_6 = $this->transactions_model->select_sum_total_method($paygol['name'], $filters);
      $total_method_7 = $this->transactions_model->select_sum_total_method($swift['name'], $filters);
      $total_method_8 = $this->transactions_model->select_sum_total_method($local_bank['name'], $filters);
      $total_method_9 = $this->transactions_model->select_sum_total_method($coinpayments['name'], $filters);
      $total_method_10 = $this->transactions_model->select_sum_total_method($blockchain['name'], $filters);
      $total_method_11 = $this->transactions_model->select_sum_total_method("system", $filters);
      // method transactions
      
      
        // setup page header data
		$this
			->add_js_theme('dashboard_i18n.js', TRUE)
			->set_title(lang('admin profit title'));

        $data = $this->includes;
      
      // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'filters'    => $filters,
            'filter'     => $filter,
            'total_deposits_confirm'   => $total_deposits_confirm,
            'total_deposits_confirm_debit_base' => $total_deposits_confirm_debit_base,
            'total_deposits_confirm_debit_extra1' => $total_deposits_confirm_debit_extra1,
            'total_deposits_confirm_debit_extra2' => $total_deposits_confirm_debit_extra2,
            'total_deposits_confirm_debit_extra3' => $total_deposits_confirm_debit_extra3,
            'total_deposits_confirm_debit_extra4' => $total_deposits_confirm_debit_extra4,
            'total_deposits_confirm_debit_extra5' => $total_deposits_confirm_debit_extra5,
            'total_withdrawal_confirm_debit_base' => $total_withdrawal_confirm_debit_base,
            'total_withdrawal_confirm_debit_extra1' => $total_withdrawal_confirm_debit_extra1,
            'total_withdrawal_confirm_debit_extra2' => $total_withdrawal_confirm_debit_extra2,
            'total_withdrawal_confirm_debit_extra3' => $total_withdrawal_confirm_debit_extra3,
            'total_withdrawal_confirm_debit_extra4' => $total_withdrawal_confirm_debit_extra4,
            'total_withdrawal_confirm_debit_extra5' => $total_withdrawal_confirm_debit_extra5,
            'total_withdrawal_confirm' => $total_withdrawal_confirm,
            'total_deposits_debit_base' => $total_deposits_debit_base,
            'total_deposits_debit_extra1' => $total_deposits_debit_extra1,
            'total_deposits_debit_extra2' => $total_deposits_debit_extra2,
            'total_deposits_debit_extra3' => $total_deposits_debit_extra3,
            'total_deposits_debit_extra4' => $total_deposits_debit_extra4,
            'total_deposits_debit_extra5' => $total_deposits_debit_extra5,
            'total_withdrawal_debit_base' => $total_withdrawal_debit_base,
            'total_withdrawal_debit_extra1' => $total_withdrawal_debit_extra1,
            'total_withdrawal_debit_extra2' => $total_withdrawal_debit_extra2,
            'total_withdrawal_debit_extra3' => $total_withdrawal_debit_extra3,
            'total_withdrawal_debit_extra4' => $total_withdrawal_debit_extra4,
            'total_withdrawal_debit_extra5' => $total_withdrawal_debit_extra5,
            'total_fee_confirm_debit_base' => $total_fee_confirm_debit_base,
            'total_fee_deposits_confirm_debit_extra1' => $total_fee_deposits_confirm_debit_extra1,
            'total_fee_deposits_confirm_debit_extra2' => $total_fee_deposits_confirm_debit_extra2,
            'total_fee_deposits_confirm_debit_extra3' => $total_fee_deposits_confirm_debit_extra3,
            'total_fee_deposits_confirm_debit_extra4' => $total_fee_deposits_confirm_debit_extra4,
            'total_fee_deposits_confirm_debit_extra5' => $total_fee_deposits_confirm_debit_extra5,
            'paypal' => $paypal,
            'perfect_m' => $perfect_m,
            'advcash' => $advcash,
            'payeer' => $payeer,
            'skrill' => $skrill,
            'paygol' => $paygol,
            'swift' => $swift,
            'local_bank' => $local_bank,
            'coinpayments' => $coinpayments,
            'blockchain' => $blockchain,
            'total_method_1' => $total_method_1,
            'total_method_2' => $total_method_2,
            'total_method_3' => $total_method_3,
            'total_method_4' => $total_method_4,
            'total_method_5' => $total_method_5,
            'total_method_6' => $total_method_6,
            'total_method_7' => $total_method_7,
            'total_method_8' => $total_method_8,
            'total_method_9' => $total_method_9,
            'total_method_10' => $total_method_10,
            'total_method_11' => $total_method_11,
            'total_method_1_1' => $total_method_1_1,
            'total_method_2_2' => $total_method_2_2,
            'total_method_3_3' => $total_method_3_3,
            'total_method_4_4' => $total_method_4_4,
            'total_method_5_5' => $total_method_5_5,
            'total_method_6_6' => $total_method_6_6,
            'total_method_7_7' => $total_method_7_7,
            'total_method_8_8' => $total_method_8_8,
            'select_sum_withd_fee_debit_base' => $select_sum_withd_fee_debit_base,
            'select_sum_transfer_fee_debit_base' => $select_sum_transfer_fee_debit_base,
            'select_sum_exchange_fee_debit_base' => $select_sum_exchange_fee_debit_base,
            'select_sum_sci_fee_debit_base' => $select_sum_sci_fee_debit_base,
            'select_sum_withd_fee_debit_extra1' => $select_sum_withd_fee_debit_extra1,
            'select_sum_transfer_fee_debit_extra1' => $select_sum_transfer_fee_debit_extra1,
            'select_sum_exchange_fee_debit_extra1' => $select_sum_exchange_fee_debit_extra1,
            'select_sum_sci_fee_debit_extra1' => $select_sum_sci_fee_debit_extra1,
            'select_sum_withd_fee_debit_extra2' => $select_sum_withd_fee_debit_extra2,
            'select_sum_transfer_fee_debit_extra2' => $select_sum_transfer_fee_debit_extra2,
            'select_sum_exchange_fee_debit_extra2' => $select_sum_exchange_fee_debit_extra2,
            'select_sum_sci_fee_debit_extra2' => $select_sum_sci_fee_debit_extra2,
            'select_sum_withd_fee_debit_extra3' => $select_sum_withd_fee_debit_extra3,
            'select_sum_transfer_fee_debit_extra3' => $select_sum_transfer_fee_debit_extra3,
            'select_sum_exchange_fee_debit_extra3' => $select_sum_exchange_fee_debit_extra3,
            'select_sum_sci_fee_debit_extra3' => $select_sum_sci_fee_debit_extra3,
            'select_sum_withd_fee_debit_extra4' => $select_sum_withd_fee_debit_extra4,
            'select_sum_transfer_fee_debit_extra4' => $select_sum_transfer_fee_debit_extra4,
            'select_sum_exchange_fee_debit_extra4' => $select_sum_exchange_fee_debit_extra4,
            'select_sum_sci_fee_debit_extra4' => $select_sum_sci_fee_debit_extra4,
            'select_sum_withd_fee_debit_extra5' => $select_sum_withd_fee_debit_extra5,
            'select_sum_transfer_fee_debit_extra5' => $select_sum_transfer_fee_debit_extra5,
            'select_sum_exchange_fee_debit_extra5' => $select_sum_exchange_fee_debit_extra5,
            'select_sum_sci_fee_debit_extra5' => $select_sum_sci_fee_debit_extra5,
            'total_withdrawal_fee_confirm_debit_base' => $total_withdrawal_fee_confirm_debit_base,
            'total_withdrawal_fee_confirm_debit_extra1' => $total_withdrawal_fee_confirm_debit_extra1,
            'total_withdrawal_fee_confirm_debit_extra2' => $total_withdrawal_fee_confirm_debit_extra2,
            'total_withdrawal_fee_confirm_debit_extra3' => $total_withdrawal_fee_confirm_debit_extra3,
            'total_withdrawal_fee_confirm_debit_extra4' => $total_withdrawal_fee_confirm_debit_extra4,
            'total_withdrawal_fee_confirm_debit_extra5' => $total_withdrawal_fee_confirm_debit_extra5,
        );
      
        // load views
        $data['content'] = $this->load->view('admin/profit/index.php', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
  
  
}