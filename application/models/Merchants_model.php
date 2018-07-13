<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Merchants_model extends CI_Model {

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
        $this->_db = 'merchants';
        $this->_db2 = 'merchant_categories';
				$this->_db3 = 'merchants_categories';
				$this->_db4 = 'items';
    }
	
	function get_merchant_user_admin($user) 
	{
		return $this->db->where("user", $user)->order_by('id', 'DESC')->get("merchants");
	}
	
	function get_user_items($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $id_merchant = NULL, $user = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db4}
						WHERE merchant_id = " . $this->db->escape($id_merchant) . " AND user = " . $this->db->escape($user) . "
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
	
	function get_select_categories($offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db2}
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
	
	function get_all_items($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db4}
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
	
	function get_select_merchant_categories($offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $merchant = NULL, $user = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db3}
						WHERE id_merchant = " . $this->db->escape($merchant) . " AND user = " . $this->db->escape($user) . "
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
	
	
	
	function get_select_merchant_categories_all($offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $merchant = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db3}
						WHERE id_merchant = " . $this->db->escape($merchant) . "
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

  
  function get_all_categories($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db2}
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
	
	function get_all_merchant_categories($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db3}
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
	
	function get_all_merchants($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
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
	
	function get_pending_merchants($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE id > '0' AND status = '1'
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
	
	function get_user_merchant($id = NULL, $username = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
								WHERE (id = " . $this->db->escape($id) . " AND user = " . $this->db->escape($username) . ")
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
	
	function get_payment_merchant($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
								WHERE (id = " . $this->db->escape($id) . " AND status = '2' AND show_category = '1' )
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
	
	function get_sci_merchant($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db}
								WHERE (id = " . $this->db->escape($id) . " AND status = '2')
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
  
  function get_category($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db2}
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
	
	function get_shop_category($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db3}
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
	
	function get_user_merchant_category($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db3}
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
	
	
	function get_merchant($id = NULL)
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
	
	function get_item($id = NULL)
    {
        if ($id)
        {
            $sql = "
                SELECT *
                FROM {$this->_db4}
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
	
	function get_cart_shop_item($id = NULL)
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
	
	function get_shops($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db2}
						WHERE status = '1'
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
	
	function get_shops_search($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE status = '2' AND show_category = '1'
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
	
	function get_shops_category($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $id = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db}
						WHERE status = '2' AND category = '{$id}' AND show_category = '1'
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
	
	function get_shops_items($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $id = NULL)
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db4}
						WHERE status = '1' AND category_id = '{$id}'
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
	
	function get_user_merchants($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC', $user = NULL)
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
  
  function edit_merchant($data = array(), $file = NULL)
    {
        if ($data)
        {
            $sql = "
                UPDATE {$this->_db2}
                SET
                    code = " . $this->db->escape($data['code']) . ",
                    status = " . $this->db->escape($data['status']) . ",
										img = " . $this->db->escape($file) . ",
                    name = " . ((is_array($data['name'])) ? $this->db->escape(serialize($data['name'])) : $this->db->escape($data['name'])) . "
                WHERE id = " . $this->db->escape($data['id']) . "
            ";

            $this->db->query($sql);

            if ($this->db->affected_rows())
            {
                return TRUE;
            }
        }

        return FALSE;
    }
	
	function edit_merchant_category($data = array())
    {
        if ($data)
        {
            $sql = "
                UPDATE {$this->_db3}
                SET
                    name = " . ((is_array($data['name'])) ? $this->db->escape(serialize($data['name'])) : $this->db->escape($data['name'])) . ",
										status = " . $this->db->escape($data['status']) . "
                WHERE id = " . $this->db->escape($data['id']) . "
            ";

            $this->db->query($sql);
            
						return TRUE;
        }

        return FALSE;
    }
	
	function add_merchant_category($data=array(), $user = NULL, $id_merchant = NULL)
    {
        if ($data)
        {

            $sql = "
                INSERT INTO {$this->_db3} (
										id_merchant,
										user,
                    status,
                    name
                ) VALUES (
										" . $this->db->escape($id_merchant) . ",
										" . $this->db->escape($user) . ",
                    " . $this->db->escape($data['status']) . ",
                    " . ((is_array($data['name'])) ? $this->db->escape(serialize($data['name'])) : $this->db->escape($data['name'])) . "
                )
            ";

            $this->db->query($sql);

            if ($id = $this->db->insert_id())
            {
                return $id;
            }
        }

        return FALSE;
    }
	
	function edit_admin_merchant($data=array(), $logo = NULL)
    {
        if ($data)
        {
            $sql = "
                UPDATE {$this->_db}
                SET
										name = " . $this->db->escape($data['name']) . ",
										fee = " . $this->db->escape($data['fee']) . ",
										fix_fee = " . $this->db->escape($data['fix_fee']) . ",
										status = " . $this->db->escape($data['status']) . ",
										success_link = " . $this->db->escape($data['success_link']) . ",
										fail_link = " . $this->db->escape($data['fail_link']) . ",
										link = " . $this->db->escape($data['link']) . ",
										status_link = " . $this->db->escape($data['status_link']) . ",
										password = " . $this->db->escape($data['password']) . ",
										category = " . $this->db->escape($data['category']) . ",
										show_category = " . $this->db->escape($data['show_category']) . ",
										payeer_fee = " . $this->db->escape($data['payeer_fee']) . ",
										test_mode = " . $this->db->escape($data['test_mode']) . ",
										comment = " . $this->db->escape($data['comment']) . ",
										note_payment = " . $this->db->escape($data['note_payment']) . ",
                    logo = " . $this->db->escape($logo) . "
                WHERE id = " . $this->db->escape($data['id']) . "
            ";

            $this->db->query($sql);

            if ($this->db->affected_rows())
            {
                return TRUE;
            }
        }

        return FALSE;
    }
	
	function edit_user_merchant($data = array())
    {
        if ($data)
        {
            $sql = "
                UPDATE {$this->_db}
                SET
                    success_link = " . $this->db->escape($data['success_link']) . ",
                    fail_link = " . $this->db->escape($data['fail_link']) . ",
										password = " . $this->db->escape($data['password']) . ",
										show_category = " . $this->db->escape($data['show_category']) . ",
										payeer_fee = " . $this->db->escape($data['payeer_fee']) . ",
										test_mode = " . $this->db->escape($data['test_mode']) . "
                WHERE id = " . $this->db->escape($data['id']) . "
            ";

            $this->db->query($sql);

            if ($this->db->affected_rows())
            {
                return TRUE;
            }
        }

        return FALSE;
    }
	
	 function add_merchant($data=array(), $code = NULL, $logo = NULL)
    {
        if ($data)
        {

            $sql = "
                INSERT INTO {$this->_db2} (
                    code,
                    status,
                    img,
                    name,
                    date
                ) VALUES (
                    " . $this->db->escape($code) . ",
                    " . $this->db->escape($data['status']) . ",
                    " . $this->db->escape($logo) . ",
                    " . ((is_array($data['name'])) ? $this->db->escape(serialize($data['name'])) : $this->db->escape($data['name'])) . ",
                    '" . date('Y-m-d H:i:s') . "'
                )
            ";

            $this->db->query($sql);

            if ($id = $this->db->insert_id())
            {
                return $id;
            }
        }

        return FALSE;
    }
	
	function add_user_merchant($data=array(), $logo = NULL, $user = NULL)
    {
        if ($data)
        {

            $sql = "
                INSERT INTO {$this->_db} (
										name,
										success_link,
										fail_link,
										link,
										status_link,
										password,
										category,
										show_category,
										payeer_fee,
										test_mode,
                    status,
                    logo,
										comment,
										note_payment,
										user,
                    date
                ) VALUES (
                    " . $this->db->escape($data['name']) . ",
                    " . $this->db->escape($data['success_link']) . ",
										" . $this->db->escape($data['fail_link']) . ",
										" . $this->db->escape($data['link']) . ",
										" . $this->db->escape($data['status_link']) . ",
										" . $this->db->escape($data['password']) . ",
										" . $this->db->escape($data['category']) . ",
										" . $this->db->escape($data['show_category']) . ",
										" . $this->db->escape($data['payeer_fee']) . ",
										" . $this->db->escape($data['test_mode']) . ",
										'1',
										" . $this->db->escape($logo) . ",
										" . $this->db->escape($data['comment']) . ",
										" . $this->db->escape($data['note_payment']) . ",
										" . $this->db->escape($user) . ",
                    '" . date('Y-m-d H:i:s') . "'
                )
            ";

            $this->db->query($sql);

            if ($id = $this->db->insert_id())
            {
                return $id;
            }
        }

        return FALSE;
    }
	
	function delete($id) {
		$this->db->where("id", $id)->delete("merchant_categories");
	}
	
	function delete_item($id) {
		$this->db->where("id", $id)->delete("items");
	}
	
	
	function delete_merchant($id) {
		$this->db->where("id", $id)->delete("merchants");
	}
	
	/**
     * Check to see if a username already exists
     *
     * @param  string $username
     * @return boolean
     */
    function category_exists($category)
    {
        $sql = "
            SELECT id
            FROM {$this->_db2}
            WHERE id = " . $this->db->escape($category) . " AND status = '1'
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows())
        {
            return TRUE;
        }

        return FALSE;
    }
	
		function category_user_merchant_exists($id, $category)
    {
        $sql = "
            SELECT id
            FROM {$this->_db3}
            WHERE id = " . $this->db->escape($category) . " AND status = '1' AND id_merchant = " . $this->db->escape($id) . "
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows())
        {
            return TRUE;
        }

        return FALSE;
    }
	
	function category_merchant($id)
    {
        $sql = "
            SELECT id
            FROM {$this->_db}
            WHERE id = " . $this->db->escape($id) . " AND status = '2' AND show_category = '1'
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows())
        {
            return TRUE;
        }

        return FALSE;
    }
	
	function get_all_shops() 
	{
		$s= $this->db->select("COUNT(*) as num")->get("merchants");
		$r = $s->row();
		if(isset($r->num)) return $r->num;
		return 0;
	}
	
	// sum requests (for menu)
  function sum_total_merchants($id)
  {
		$where = "(status = '2' AND category = '{$id}') AND show_category = '1'";
  	$s= $this->db->where($where)->select("COUNT(*) as num")->get("merchants");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Merchant;
  }
	
	// sum requests (for menu)
  function sum_total_items($merchant_id, $category_id)
  {
		$where = "(status = '1' AND category_id = '{$category_id}') AND merchant_id = '{$merchant_id}'";
  	$s= $this->db->where($where)->select("COUNT(*) as num")->get("items");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Items;
  }
  
	function delete_category_user_merchant($id) {
		$this->db->where("id", $id)->delete("merchants_categories");
	}
	
	function delete_user_items($id) {
		$this->db->where("id", $id)->delete("items");
	}
  
	function add_item($data) 
	{
		$this->db->insert("items", $data);
		return $this->db->insert_id();
	}
	
	function update_item($id, $data) 
	{
		$this->db->where("id", $id)->update("items", $data);
	}
	
	// total merchants ////////////////////////////////////////////
  function total_dash_merchants()
  {
  	$s= $this->db->select("COUNT(*) as num")->get("merchants");
    $r = $s->row();
    if(isset($r->num)) return $r->num;
    return 0;

    return $result[0]->Merchants;
  }
	
	function get_pending_dash($user) 
	{
		$where = "status = '1'";
		return $this->db->where($where)->order_by('id', 'DESC')->limit(20)->get("merchants");
	}
	
}