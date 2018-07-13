<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

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
        $this->_db = 'carts';
    }
	
	function get_admin_cart($user) 
	{
		return $this->db->where("user", $user)->order_by('id', 'DESC')->get("carts");
	}
	
	function get_cart($id = NULL)
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
  
  function get_user_cart($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $user = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE user = " . $this->db->escape($user) . "
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
  
  // sum requests (for menu)
  function sum_total_items($user)
  {
		$where = "user = '{$user}'";
  	$s= $this->db->where($where)->select("COUNT(*) as num")->get("carts");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Carts;
  }
	
	function delete_cart($id) {
		$this->db->where("id", $id)->delete("carts");
	}
	
	function add_cart($data) 
	{
		$this->db->insert("carts", $data);
		return $this->db->insert_id();
	}
  
}