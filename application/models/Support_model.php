<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Support_model extends CI_Model {

    /**
     * @vars
     */
    private $_db;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // define primary table
        $this->_db = 'tickets';
    }
	
		function get_support_user_admin($user) 
		{
			return $this->db->where("user", $user)->order_by('id', 'DESC')->limit(20)->get("tickets");
		}
  
    function get_all($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE id > '0'
        ";

        if ( ! empty($filters))
        {
            foreach ($filters as $key=>$value)
            {
                $value = $this->db->escape('%' . $value . '%');
                $sql .= " AND {$key} LIKE {$value}";
            }
        }

        $sql .= " ORDER BY {$sort} {$dir}";

        if ($limit)
        {
            $sql .= " LIMIT {$offset}, {$limit}";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            $results['results'] = $query->result_array();
        }
        else
        {
            $results['results'] = NULL;
        }

        $sql = "SELECT FOUND_ROWS() AS total";
        $query = $this->db->query($sql);
        $results['total'] = $query->row()->total;

        return $results;
    }
  
    function get_untreated($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE status = '0'
        ";

        if ( ! empty($filters))
        {
            foreach ($filters as $key=>$value)
            {
                $value = $this->db->escape('%' . $value . '%');
                $sql .= " AND {$key} LIKE {$value}";
            }
        }

        $sql .= " ORDER BY {$sort} {$dir}";

        if ($limit)
        {
            $sql .= " LIMIT {$offset}, {$limit}";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            $results['results'] = $query->result_array();
        }
        else
        {
            $results['results'] = NULL;
        }

        $sql = "SELECT FOUND_ROWS() AS total";
        $query = $this->db->query($sql);
        $results['total'] = $query->row()->total;

        return $results;
    }
	
		function get_tickets($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
                WHERE id = " . $this->db->escape($id) . "
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
	
		function get_id_comment($code = NULL)
    {
        if ($code)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
                WHERE code = " . $this->db->escape($code) . "
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
    
    // sum tickets (for menu)
    function sum_tickets($status)
    {
      $s= $this->db->where("status", $status)->select("COUNT(*) as num")->get("tickets");
      $r = $s->row();
      if(isset($r->num)) return $r->num;
      return 0;

      return $result[0]->Status;
    }
	
		function get_log_comment($id) 
		{
			return $this->db->where("id_ticket", $id)->order_by('id', 'ASC')->get("tickets_comments");
		}
	
		function add_admin_comment($data) 
		{
			$this->db->insert("tickets_comments", $data);
			return $this->db->insert_id();
		}
	
		function update_ticket($id, $data) {
			$this->db->where("ID", $id)->update("tickets", $data);
		}
	
		function add_ticket($data) 
		{
			$this->db->insert("tickets", $data);
			return $this->db->insert_id();
		}
	
		function get_list_tickets($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $user = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE user = '{$user}'
        ";

        if ( ! empty($filters))
        {
            foreach ($filters as $key=>$value)
            {
                $value = $this->db->escape('%' . $value . '%');
                $sql .= " AND {$key} LIKE {$value}";
            }
        }

        $sql .= " ORDER BY {$sort} {$dir}";

        if ($limit)
        {
            $sql .= " LIMIT {$offset}, {$limit}";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            $results['results'] = $query->result_array();
        }
        else
        {
            $results['results'] = NULL;
        }

        $sql = "SELECT FOUND_ROWS() AS total";
        $query = $this->db->query($sql);
        $results['total'] = $query->row()->total;

        return $results;
    }
	
		function get_detail_ticket($code = NULL, $username = NULL)
    {
        if ($code)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
								WHERE code = " . $this->db->escape($code) . " AND user = " . $this->db->escape($username) . "
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }	
	
		// sum requests (for menu)
  function sum_user_support($user)
  {
		$where = "(status = '1' AND user = '{$user}')";
  	$s= $this->db->where($where)->select("COUNT(*) as num")->get("tickets");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Tickets;
  }
	
		// sum requests (for menu)
  function sum_admin_support()
  {
		$where = "(status = '0')";
  	$s= $this->db->where($where)->select("COUNT(*) as num")->get("tickets");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Tickets;
  }
	
	// total support ////////////////////////////////////////////
  function total_dash_support()
  {
  	$s= $this->db->select("COUNT(*) as num")->get("tickets");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Tickets;
  }
	
	function get_pending_dash($user) 
	{
		$where = "status = '0'";
		return $this->db->where($where)->order_by('id', 'DESC')->limit(20)->get("tickets");
	}
  
}