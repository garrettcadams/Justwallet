<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Verification_model extends CI_Model {

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
        $this->_db = 'verification';
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
						WHERE id > '0' AND status = '0'
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
	
		function add_document($data) 
		{
			$this->db->insert("verification", $data);
			return $this->db->insert_id();
		}
	
		function get_verification($user = NULL)
    {
        if ($user)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
                WHERE user = " . $this->db->escape($user) . " AND status = '0'
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }	
	
		function get_request($id = NULL)
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
	
		function get_user_request($user) 
		{
			return $this->db->where("user", $user)->order_by('id', 'DESC')->get("verification");
		}
	
		function update_verification($code, $data) {
			$this->db->where("code", $code)->update("verification", $data);
		}
	
		function delete_doc($id) {
			$this->db->where("id", $id)->delete("verification");
		}
	
		// sum requests (for menu)
    function sum_verification($status)
    {
      $s= $this->db->where("status", $status)->select("COUNT(*) as num")->get("verification");
      $r = $s->row();
      if(isset($r->num)) return $r->num;
      return 0;

      return $result[0]->Status;
    }
	
	function get_pending_dash($user) 
	{
		$where = "status = '0'";
		return $this->db->where($where)->order_by('id', 'DESC')->limit(20)->get("verification");
	}
	
		// sum requests (for menu)
  function sum_admin_verify()
  {
		$where = "(status = '0')";
  	$s= $this->db->where($where)->select("COUNT(*) as num")->get("verification");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Verification;
  }
	
}