<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends Private_Controller {

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
				$this->load->model('disputes_model');
				$this->load->library('fixer');
			
				// set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/transactions'));
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
		
		if ($this->input->get('time'))
    {
      $time_xss = $this->security->xss_clean($this->input->get('time'));
			$time_string = htmlentities($time_xss, ENT_QUOTES, "UTF-8");
			$filters['time'] = $time_string;
    }
		
		if ($this->input->get('sender'))
    {
      $sender_xss = $this->security->xss_clean($this->input->get('sender'));
			$sender_string = htmlentities($sender_xss, ENT_QUOTES, "UTF-8");
			$filters['sender'] = $sender_string;
    }
		
		if ($this->input->get('receiver'))
    {
      $receiver_xss = $this->security->xss_clean($this->input->get('receiver'));
			$receiver_string = htmlentities($receiver_xss, ENT_QUOTES, "UTF-8");
			$filters['receiver'] = $receiver_string;
    }
		
		if ($this->input->get('sum'))
    {
      $sum_xss = $this->security->xss_clean($this->input->get('sum'));
			$sum_string = htmlentities($sum_xss, ENT_QUOTES, "UTF-8");
			$filters['sum'] = $sum_string;
    }
		
		if ($this->input->get('user_comment'))
    {
      $user_comment_xss = $this->security->xss_clean($this->input->get('user_comment'));
			$user_comment_string = htmlentities($user_comment_xss, ENT_QUOTES, "UTF-8");
			$filters['user_comment'] = $user_comment_string;
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
								if ($this->input->post('time'))
                {
                    $filter .= "&time=" . $this->input->post('time', TRUE);
                }
							
								if ($this->input->post('sender'))
                {
                    $filter .= "&sender=" . $this->input->post('sender', TRUE);
                }
							
								if ($this->input->post('receiver'))
                {
                    $filter .= "&receiver=" . $this->input->post('receiver', TRUE);
                }
							
								if ($this->input->post('sum'))
                {
                    $filter .= "&sum=" . $this->input->post('sum', TRUE);
                }
							
								if ($this->input->post('user_comment'))
                {
                    $filter .= "&user_comment=" . $this->input->post('user_comment', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$history = $this->transactions_model->get_user_transactions($limit, $offset, $filters, $sort, $dir, $user['username']);
				
		}
		
     // setup page header data
     $this->set_title(sprintf(lang('users title history'), $this->settings->site_name));
		// reload the new user data and store in session

    $data = $this->includes;
					
		$history = $this->transactions_model->get_user_transactions($limit, $offset, $filters, $sort, $dir, $user['username']);
					
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
        $data['content'] = $this->load->view('account/transactions/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

	
	
	/**
    * Detail transaction
    */
	function detail($id = NULL)
    {
		$user = $this->users_model->get_user($this->user['id']);
			
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $transactions = $this->transactions_model->get_detail_transactions($id, $user['username']);

        // if empty results, return to list
        if ( ! $transactions)
        {
            redirect($this->_redirect_url);
        }
			
			//Check dispute history
			$dispute_history = $this->disputes_model->get_history_dispute($id);
			if ( $dispute_history)
			{
				$dispute_mode = "0"; // no start dispute
			} else {
				$dispute_mode = "1"; // yes start dispute
			}
			
        // setup page header data
        $this->set_title( lang('users title history') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   		=> THIS_URL,
			'user'              => $user,
			'dispute_mode'      => $dispute_mode,
            'cancel_url'        => $this->_redirect_url,
            'transactions'      => $transactions,
            'transactions_id'   => $id
        );

        // load views
        $data['content'] = $this->load->view('account/transactions/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	/**
     * Start confirm protect transaction
   */
	
	function protect_confirm()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('code_protect', lang('users transfer code_protect'), 'required|trim|numeric|max_length[4]|min_length[4]');
		$this->form_validation->set_rules('id', lang('users col user_id'), 'required|trim|numeric|min_length[1]');
		
		if ($this->form_validation->run() == TRUE) {
			
			$id = $this->input->post("id", TRUE);
			
			$transactions = $this->transactions_model->get_transactions($id);
			
			$check_start_user = $this->users_model->get_username($transactions['receiver']);
		
			$sender_transfer = $this->users_model->get_username($transactions['sender']);

			$wallet = $transactions['currency'];
			
			$code_protect = $this->input->post("code_protect", TRUE);
			
			if ($user['username'] == $check_start_user['username']) {
				
				// check protect
				if ($transactions['protect'] != "none") {
			
					// check status
					if ($transactions['status'] == 1) {

						if ($code_protect == $transactions['protect']) {

							// Calculation of the amount to be credited to receiver
							$transfer = $user[$wallet]+$transactions['amount'];

							// update transaction history
							$this->transactions_model->update_dispute_transactions($transactions['id'],
								array(
									"status"   	 => "2",
								)
							);

							// update wallet sender
							$this->users_model->update_user($transactions['receiver'],
								array(
									$transactions['currency']  => $transfer,
									)
							);

							$this->session->set_flashdata('message', lang('users transfer success'));
							redirect(site_url("account/transactions"));

						} else {
							
							// add attempt
							$attempt = $transactions['protect_attempts'] + "1";
							
							// update transaction history
							$this->transactions_model->update_dispute_transactions($transactions['id'],
								array(
									"protect_attempts"   => $attempt,
								)
							);
							
							$transactions = $this->transactions_model->get_transactions($id);
							
							if($transactions['protect_attempts'] >= 3) {
								
								// update wallet sender
								$this->users_model->update_user($transactions['receiver'],
									array(
										"fraud"  => "1",
									)
								);
								
								// update transaction history
								$this->transactions_model->update_dispute_transactions($transactions['id'],
									array(
										"status"   	 => "3",
									)
								);
								
								// Calculation of the amount to be credited to sender
								$return = $sender_transfer[$wallet]+$transactions['amount'];
								
								// update wallet sender
								$this->users_model->update_user($transactions['sender'],
									array(
										$transactions['currency']  => $return,
									)
								);
								
							}

							$this->session->set_flashdata('error', lang('users error invalid_form'));
							redirect(site_url("account/transactions"));

						}

					} else {

						$this->session->set_flashdata('error', lang('users error invalid_form'));
						redirect(site_url("account/transactions"));

					}

				} else {

					$this->session->set_flashdata('error', lang('users error invalid_form'));
					redirect(site_url("account/transactions"));

				}
				
			} else {
				
				$this->session->set_flashdata('error', lang('users error invalid_form'));
				redirect(site_url("account/transactions"));
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users error invalid_form'));
			redirect(site_url("account/transactions"));
			
		}
		
	}
	
	
	/**
     * Start refund protect transaction
   */
	function protect_refund($id)
	{
		// make sure we have a numeric id
    if (is_null($id) OR ! is_numeric($id))
    {
    	redirect(site_url("account/transactions"));
    }
		
		// get the data
    $transactions = $this->transactions_model->get_transactions($id);
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$check_start_user = $this->users_model->get_username($transactions['receiver']);
		
		$sender_transfer = $this->users_model->get_username($transactions['sender']);
		
		$wallet = $transactions['currency'];
		
		// check status
		if ($transactions['status'] == 1) {
		
			// check protect
			if ($transactions['protect'] != "none") {

				// Calculation of the amount to be credited to sender
				$return = $sender_transfer[$wallet]+$transactions['amount'];

				if ($user['username'] == $check_start_user['username']) {

					// update transaction history
					$this->transactions_model->update_dispute_transactions($transactions['id'],
						array(
							"status"   	 => "3",
						)
					);

					// update wallet sender
					$this->users_model->update_user($transactions['sender'],
						array(
							$transactions['currency']  => $return,
							)
						);

					$this->session->set_flashdata('message', lang('users refund success'));
					redirect(site_url("account/transactions"));

				} else {

					$this->session->set_flashdata('error', lang('users error invalid_form'));
					redirect(site_url("account/transactions"));

				}

			} else {

				$this->session->set_flashdata('error', lang('users error invalid_form'));
				redirect(site_url("account/transactions"));

			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users error invalid_form'));
			redirect(site_url("account/transactions"));
			
		}
		
	}
  
}