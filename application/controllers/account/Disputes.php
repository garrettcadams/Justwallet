<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disputes extends Private_Controller {

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
				$this->load->model('template_model');
      
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('account/disputes'));
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
		
		$username = $user['username'];
		
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
				$id_string = str_replace(' ', '-', $id_xss);
				$id_replace = preg_replace('/[^A-Za-z0-9\-]/', '', $id_string);
				$filters['id'] = $id_replace;
      }
		
			if ($this->input->get('time_dispute', TRUE))
      {
				$time_dispute_xss = $this->security->xss_clean($this->input->get('time_dispute'));
				$time_dispute_string = htmlentities($time_dispute_xss, ENT_QUOTES, "UTF-8");
				$filters['time_dispute'] = $time_dispute_string;
      }
		
			if ($this->input->get('transaction', TRUE))
      {
				$transaction_xss = $this->security->xss_clean($this->input->get('transaction'));
				$transaction_string = htmlentities($transaction_xss, ENT_QUOTES, "UTF-8");
				$filters['transaction'] = $transaction_string;
      }
		
			if ($this->input->get('amount', TRUE))
      {
				$amount_xss = $this->security->xss_clean($this->input->get('amount'));
				$amount_string = htmlentities($amount_xss, ENT_QUOTES, "UTF-8");
				$filters['amount'] = $amount_string;
      }
		
			if ($this->input->get('claimant', TRUE))
      {
        $claimant_xss = $this->security->xss_clean($this->input->get('claimant'));
				$claimant_string = htmlentities($claimant_xss, ENT_QUOTES, "UTF-8");
				$filters['claimant'] = $claimant_string;
      }
		
			if ($this->input->get('defendant', TRUE))
      {
        $claimant_xss = $this->security->xss_clean($this->input->get('defendant'));
				$defendant_string = htmlentities($defendant_xss, ENT_QUOTES, "UTF-8");
				$filters['defendant'] = $defendant_string;
      }
		
			if ($this->input->get('message', TRUE))
      {
        $message_xss = $this->security->xss_clean($this->input->get('message'));
				$message_string = htmlentities($message_xss, ENT_QUOTES, "UTF-8");
				$filters['message'] = $message_string;
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
							
								if ($this->input->post('time_dispute'))
                {
                    $filter .= "&time_dispute=" . $this->input->post('time_dispute', TRUE);
                }
							
								if ($this->input->post('transaction'))
                {
                    $filter .= "&transaction=" . $this->input->post('transaction', TRUE);
                }
							
								if ($this->input->post('amount'))
                {
                    $filter .= "&amount=" . $this->input->post('amount', TRUE);
                }
							
								if ($this->input->post('claimant'))
                {
                    $filter .= "&claimant=" . $this->input->post('claimant', TRUE);
                }
							
								if ($this->input->post('defendant'))
                {
                    $filter .= "&defendant=" . $this->input->post('defendant', TRUE);
                }
							
								if ($this->input->post('message'))
                {
                    $filter .= "&message=" . $this->input->post('message', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
					
			$dispute = $this->disputes_model->get_list_dispute($limit, $offset, $filters, $sort, $dir, $username);
				
		}
		
        // setup page header data
        $this->set_title(sprintf(lang('users title resolution'), $this->settings->site_name));
		// reload the new user data and store in session

        $data = $this->includes;
					
		$dispute = $this->disputes_model->get_list_dispute($limit, $offset, $filters, $sort, $dir, $username);
		
		$user = $this->users_model->get_user($this->user['id']);
					
		// build pagination
		$this->pagination->initialize(array(
			'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
			'total_rows' => $dispute['total'],
			'per_page'   => $limit
		));
			
		// set content data
        $content_data = array(
			'user'       => $user,
			'username'   => $username,
            'this_url'   => THIS_URL,
            'dispute'    => $dispute['results'],
            'total'    	 => $dispute['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );


        // load views
        $data['content'] = $this->load->view('account/disputes/index', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}
	
	
  /**
    * Detail dispute
    */
	function detail($id = NULL)
    {
		$user = $this->users_model->get_user($this->user['id']);
			
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect(THIS_URL_2);
        }

        // get the data
        $dispute = $this->disputes_model->get_detail_dispute($id, $user['username']);
		$log_comment = $this->disputes_model->get_log_comment($dispute['id']);

        // if empty results, return to list
        if ( ! $dispute)
        {
            redirect(THIS_URL_2);
        }

        // setup page header data
        $this->set_title( lang('users title det_dispute') );

        $data = $this->includes;

        // set content data
        $content_data = array(
			'this_url'   			=> THIS_URL_2,
			'user'              	=> $user,
            'cancel_url'        	=> THIS_URL_2,
            'dispute'      			=> $dispute,
			'log_comment'   		=> $log_comment,
            'dispute_id'   			=> $id
        );

        // load views
        $data['content'] = $this->load->view('account/disputes/detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
	
	function start_dispute()
	{
		
		$user = $this->users_model->get_user($this->user['id']);
		
		$this->form_validation->set_rules('title', lang('users history dispute_title'), 'required|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('message', lang('users history reason'), 'required|min_length[10]|max_length[1000]');
    $this->form_validation->set_rules('id', lang('users trans id'), 'required|trim');
		
		if ($this->form_validation->run() == FALSE) {
      
      $this->session->set_flashdata('error', lang('users error invalid_form'));
			redirect(site_url("account/transactions"));
      
    } else {
			
			// get the data
      $id = $this->input->post("id", TRUE);
			
			$transactions = $this->transactions_model->get_detail_transactions($id, $user['username']);
			
			if ($transactions) {
				
				// Check dispute history
				$dispute_history = $this->disputes_model->get_history_dispute($id);
				
				if ($dispute_history) { // if the dispute has already opened
					
					$this->session->set_flashdata('error', lang('users error fraud'));
      		redirect(site_url("account/transactions"));
					
				} else {
					
					if ($transactions['status'] == 2 ) {
						
						if ($transactions['sender'] == $user['username'] ) {
							
							if ($transactions['type'] != 2 & $transactions['type'] != 4) {
					
								$title = $this->input->post("title", TRUE);
								$message = $this->input->post("message", TRUE);

								$dispute = $this->disputes_model->add_dispute(array(
									"title"  			=> $title,
									"message" 			=> $message,
									"transaction" 		=> $transactions['id'],
									"time_transaction" 	=> $transactions['time'],
									"time_dispute"   	=> date('Y-m-d H:i:s'),
									"claimant"   		=> $user['username'],
									"defendant"   		=> $transactions['receiver'],
									"status" 			=> "1",
									"sum"   			=> $transactions['sum'],
									"fee"   			=> $transactions['fee'],
									"amount"   			=> $transactions['amount'],
									"currency"   		=> $transactions['currency']
									)
								);

								// update transaction history
								$this->transactions_model->update_dispute_transactions($transactions['id'],
									array(
										"status"   		=> "4",
									)
								);
								
								$user2 = $this->users_model->get_username($transactions['receiver']);
								
								$email_template = $this->template_model->get_email_template(12);
								
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user['first_name'] . ' ' . $user['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[CLAIMANT]','[ID_TRANSACTION]');

									$vals_1 = array($site_name, $link, $name_user, $user['username'], $transactions['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user2['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
								
								$sms_template = $this->template_model->get_sms_template(10);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[CLAIMANT]','[ID_TRANSACTION]');

										$vals_1 = array($user['username'], $transactions['id']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user2['phone'], $str_1);
										
									}

								$this->session->set_flashdata('message', lang('users history dispute_success'));
								redirect(site_url("account/disputes"));
								
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
				
			} else {
				
				$this->session->set_flashdata('error', lang('users error invalid_form'));
				redirect(site_url("account/transactions"));
				
			}
			
		}
		
		
	}
  
  function add_comment() 
  {
    
    $user = $this->users_model->get_user($this->user['id']);
    
    $this->form_validation->set_rules('comment', lang('users disputes new_comment'), 'required|min_length[10]|max_length[1000]');
    $this->form_validation->set_rules('id', lang('users trans id'), 'required|trim');
    
    if ($this->form_validation->run() == FALSE) {
      
      $this->session->set_flashdata('error', lang('users error invalid_form'));
			redirect(site_url("account/disputes"));
      
    } else {
      
      // get the data
      $id = $this->input->post("id", TRUE);
      
      $dispute = $this->disputes_model->get_detail_dispute($id, $user['username']);
      
        // not null dispute for user
        if ($dispute) { 
          
          if ($dispute['status'] != 3 && $dispute['status'] != 4) {
          
            $comment = $this->input->post("comment", TRUE);

            $comments = $this->disputes_model->add_admin_comment(array(
              "id_dispute" 		=> $dispute['id'],
              "time"          	=> date('Y-m-d H:i:s'),
              "user"          	=> $user['username'],
              "role"          	=> "1",
              "comment"       	=> $comment,
              )
            );
						
						$user_mail1 = $this->users_model->get_username($dispute['claimant']);
							
						$user_mail2 = $this->users_model->get_username($dispute['defendant']);
						
						$email_template = $this->template_model->get_email_template(13);
								
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail1['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
						
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail2['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
						
								$sms_template = $this->template_model->get_sms_template(11);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[ID_DISPUTE]');

										$vals_1 = array($dispute['id']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user_mail1['phone'], $str_1);
										
									}
						
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[ID_DISPUTE]');

										$vals_1 = array($dispute['id']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user_mail2['phone'], $str_1);
										
									}

            $this->session->set_flashdata('message', lang('users disputes comment_success'));
            redirect(site_url("account/disputes"));
            
          } else {
            
            $this->session->set_flashdata('error', lang('users error invalid_form'));
            redirect(site_url("account/disputes"));
            
          }

       } else {

        $this->session->set_flashdata('error', lang('users error invalid_form'));
        redirect(site_url("account/disputes"));

       }
      
    }
      
  }
  
  function open_claim($id) 
  {
    
    $user = $this->users_model->get_user($this->user['id']);
    
    // get the data
    $dispute = $this->disputes_model->get_detail_dispute($id, $user['username']);
		// if empty results, return to list
    if ( ! $dispute)
    {
       redirect(THIS_URL);
    }
    
    if ($dispute) {
    
      if ($dispute['status'] == 1) {
      // update dispute
      $this->disputes_model->update_dispute($id,
        array(
          "status"   => "2",
          )
        );

      // add notification comment listing
      $comments = $this->disputes_model->new_comment(array(
        "id_dispute" 		  => $dispute['id'],
        "user" 		      	=> $user['username'],
        "role" 		      	=> "3",
        "comment" 		  	=> lang('users disputes transferred'),
        "time"          	=> date('Y-m-d H:i:s'),
        )
      );
				
			$user_mail1 = $this->users_model->get_username($dispute['claimant']);
							
			$user_mail2 = $this->users_model->get_username($dispute['defendant']);
				
			$email_template = $this->template_model->get_email_template(14);
								
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail1['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
						
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail2['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
				
								$sms_template = $this->template_model->get_sms_template(12);
							
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[ID_DISPUTE]');

										$vals_1 = array($dispute['id']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user_mail1['phone'], $str_1);
										
									}
				
									if($sms_template['status'] == "1") {
										
										$rawstring = $sms_template['message'];

										// what will we replace
										$placeholders = array('[ID_DISPUTE]');

										$vals_1 = array($dispute['id']);

										//replace
										$str_1 = str_replace($placeholders, $vals_1, $rawstring);

										$result = $this->sms->send_sms($user_mail2['phone'], $str_1);
										
									}

      $this->session->set_flashdata('message', lang('users disputes open_claim_success'));
      redirect(site_url("account/disputes"));

    } else {

      $this->session->set_flashdata('error', lang('users error invalid_form'));
      redirect(site_url("account/disputes"));

    }
      
  } else {
      
      $this->session->set_flashdata('error', lang('users error invalid_form'));
      redirect(site_url("account/disputes"));
      
  }
  
  }
  
  function cancel_claim($id) 
  {
    
    $user = $this->users_model->get_user($this->user['id']);
    
    // get the data
    $dispute = $this->disputes_model->get_detail_dispute($id, $user['username']);
		// if empty results, return to list
    if ( ! $dispute)
    {
       redirect(THIS_URL);
    }
    
    if ($dispute) {
			
			if ($dispute['claimant'] == $user['username']) {
				
				if ($dispute['status'] == 1) {
        
				// update dispute
				$this->disputes_model->update_dispute($id,
					array(
						"status"   => "3",
						)
					);

				// add notification comment listing
				$comments = $this->disputes_model->new_comment(array(
					"id_dispute" 		  => $dispute['id'],
					"user" 		      	=> $user['username'],
					"role" 		      	=> "3",
					"comment" 		  	=> lang('users disputes stop'),
					"time"          	=> date('Y-m-d H:i:s'),
					)
				);

				// update transaction history
				$this->transactions_model->update_dispute_transactions($dispute['transaction'],
					array(
						"status"		=> "2",
					)
				);
					
				$user_mail1 = $this->users_model->get_username($dispute['claimant']);
							
			$user_mail2 = $this->users_model->get_username($dispute['defendant']);
				
			$email_template = $this->template_model->get_email_template(15);
								
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail1['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
						
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail2['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}

				$this->session->set_flashdata('message', lang('users disputes open_claim_success'));
				redirect(site_url("account/disputes"));

			} elseif ($dispute['status'] == 2) { 

					// update dispute
				$this->disputes_model->update_dispute($id,
					array(
						"status"   => "3",
						)
					);

				// add notification comment listing
				$comments = $this->disputes_model->new_comment(array(
					"id_dispute" 		  => $dispute['id'],
					"user" 		      	=> $user['username'],
					"role" 		      	=> "3",
					"comment" 		  	=> lang('users disputes stop'),
					"time"          	=> date('Y-m-d H:i:s'),
					)
				);

				// update transaction history
				$this->transactions_model->update_dispute_transactions($dispute['transaction'],
					array(
						"status"		=> "2",
					)
				);
					
					$user_mail1 = $this->users_model->get_username($dispute['claimant']);
							
			$user_mail2 = $this->users_model->get_username($dispute['defendant']);
				
			$email_template = $this->template_model->get_email_template(15);
								
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail1['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
						
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail2['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}

				$this->session->set_flashdata('message', lang('users disputes open_claim_success'));
				redirect(site_url("account/disputes"));

			} else {

				$this->session->set_flashdata('error', lang('users error invalid_form'));
				redirect(site_url("account/disputes"));

			}
				
			} else {
				
				$this->session->set_flashdata('error', lang('users error invalid_form'));
      	redirect(site_url("account/disputes"));
				
			}
      
      
  } else {
      
      $this->session->set_flashdata('error', lang('users error invalid_form'));
      redirect(site_url("account/disputes"));
      
  }
  
  }
	
	function refund($id) 
  {
		
		$user = $this->users_model->get_user($this->user['id']);
    
    // get the data
    $dispute = $this->disputes_model->get_detail_dispute($id, $user['username']);
		// if empty results, return to list
    if ( ! $dispute)
    {
       redirect(THIS_URL);
    }
		
		if ($dispute) {
			
			if ($dispute['defendant'] == $user['username']) {
				
				if ($dispute['status'] != 3 && $dispute['status'] != 4) {
					
					$wallet = $dispute['currency'];
					$amount = $dispute['amount'];
					$claimant = $this->users_model->get_username($dispute['claimant']);
					
					// update dispute
					$this->disputes_model->update_dispute($dispute['id'],
						array(
							"status"   => "4",
						)
					);
					
					// Calculation of the amount to debit the defendant's account
					$refund = $user[$wallet]-$amount;

					// Calculation of the amount to be credited to the claimant 
					$return = $claimant[$wallet]+$amount;
					
					// update defendant fraud status and wallet
					$this->users_model->update_user($dispute['defendant'],
						array(
							$dispute['currency']  => $refund,
						)
					);

					// update claimant wallet
					$this->users_model->update_user($dispute['claimant'],
						array(
							$dispute['currency']  => $return,
						)
					);
					
					// add notification comment listing
					$comments = $this->disputes_model->new_comment(array(
						"id_dispute" 		=> $dispute['id'],
						"user" 		      => $this->settings->site_name,
						"role" 		      => "3",
						"comment" 		  => lang('users orders success_dispute'),
						"time"          => date('Y-m-d H:i:s'),
						)
					);

					// update transaction history
					$this->transactions_model->update_dispute_transactions($dispute['transaction'],
						array(
							"status"   		=> "3",
						)
					);
					
					$user_mail1 = $this->users_model->get_username($dispute['claimant']);
							
						$user_mail2 = $this->users_model->get_username($dispute['defendant']);
						
						$email_template = $this->template_model->get_email_template(21);
								
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail1['first_name'] . ' ' . $user_mail1['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]', '[ID_TRANSACTION]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id'], $dispute['transaction']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail1['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}
						
								if($email_template['status'] == "1") {
			
									// variables to replace
									$site_name = $this->settings->site_name;
									$link = site_url('account/disputes');
									$name_user = $user_mail2['first_name'] . ' ' . $user_mail2['last_name'];

									$rawstring = $email_template['message'];

									// what will we replace
									$placeholders = array('[SITE_NAME]','[SITE_LINK]','[NAME]','[ID_DISPUTE]', '[ID_TRANSACTION]');

									$vals_1 = array($site_name, $link, $name_user, $dispute['id'], $dispute['transaction']);

									//replace
									$str_1 = str_replace($placeholders, $vals_1, $rawstring);

									$this -> email -> from($this->settings->site_email, $this->settings->site_name);
									$this->email->to($user_mail2['email']);
									//$this -> email -> to($user['email']);
									$this -> email -> subject($email_template['title']);

									$this -> email -> message($str_1);

									$this->email->send();

								}

					
					$this->session->set_flashdata('message', lang('users orders success_dispute'));
					redirect(site_url("account/disputes"));
					
				} else {
					
					$this->session->set_flashdata('error', lang('users error invalid_form'));
      		redirect(site_url("account/disputes"));
					
				}
				
			} else {
				
				$this->session->set_flashdata('error', lang('users error invalid_form'));
      	redirect(site_url("account/disputes"));
				
			}
			
		} else {
			
			$this->session->set_flashdata('error', lang('users error invalid_form'));
      redirect(site_url("account/disputes"));
			
		}
		
	}
  
}