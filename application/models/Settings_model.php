<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

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
        $this->_db = 'settings';
        $this->_db2 = 'settings_withdrawal';
        $this->_db3 = 'settings_deposit';
    }


    /**
     * Retrieve all settings
     *
     * @return array|null
     */
    function get_settings()
    {
        $results = NULL;

        $sql = "
            SELECT *
            FROM {$this->_db}
            ORDER BY sort_order ASC
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            $results = $query->result_array();
        }

        return $results;
    }
  
    function get_twilio_lib($id = NULL)
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


    /**
     * Save changes to the settings
     *
     * @param  array $data
     * @param  int $user_id
     * @return boolean
     */
    function save_settings($data=array(), $user_id=NULL)
    {
        if ($data && $user_id)
        {
            $saved = FALSE;

            foreach ($data as $key => $value)
            {
                $sql = "
                    UPDATE {$this->_db}
                    SET value = " . ((is_array($value)) ? $this->db->escape(serialize($value)) : $this->db->escape($value)) . ",
                        last_update = '" . date('Y-m-d H:i:s') . "',
                        updated_by = " . $this->db->escape($user_id) . "
                    WHERE name = " . $this->db->escape($key) . "
                ";

                $this->db->query($sql);

                if ($this->db->affected_rows() > 0)
                {
                    $saved = TRUE;
                }
            }

            if ($saved)
            {
                return TRUE;
            }
        }

        return FALSE;
    }
  
    function get_all_withdrawal($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db2}
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
  
    function get_all_deposit($limit = 0, $offset = 0, $filters = array(), $sort = 'dir', $dir = 'ASC')
    {
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS *
            FROM {$this->_db3}
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
  
    function get_win_method($id = NULL)
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
  
    function get_dep_method($id = NULL)
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
  
    function get_dep_method_name($name = NULL)
    {
        if ($name)
        {
            $sql = "
                SELECT *
                FROM {$this->_db3}
                WHERE name = " . $this->db->escape($name) . "
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
  
    function get_win_method_name($name = NULL)
    {
        if ($name)
        {
            $sql = "
                SELECT *
                FROM {$this->_db2}
                WHERE name = " . $this->db->escape($name) . "
            ";

            $query = $this->db->query($sql);

            if ($query->num_rows())
            {
                return $query->row_array();
            }
        }

        return FALSE;
    }
  
    function edit_win_methode($data = array())
    {
        if ($data)
        {
            $sql = "
                UPDATE {$this->_db2}
                SET
                    name = " . $this->db->escape($data['name']) . ",
                    fee_fix = " . $this->db->escape($data['fee_fix']) . ",
                    fee = " . $this->db->escape($data['fee']) . ",
                    terms = " . $this->db->escape($data['terms']) . ",
                    start_verify = " . $this->db->escape($data['start_verify']) . ",
                    standart_verify = " . $this->db->escape($data['standart_verify']) . ",
                    expanded_verify = " . $this->db->escape($data['expanded_verify']) . ",
                    debit_base = " . $this->db->escape($data['debit_base']) . ",
                    debit_extra1 = " . $this->db->escape($data['debit_extra1']) . ",
                    debit_extra2 = " . $this->db->escape($data['debit_extra2']) . ",
                    debit_extra3 = " . $this->db->escape($data['debit_extra3']) . ",
                    debit_extra4 = " . $this->db->escape($data['debit_extra4']) . ",
                    debit_extra5 = " . $this->db->escape($data['debit_extra5']) . ",
                    minimum_debit_base = " . $this->db->escape($data['minimum_debit_base']) . ",
                    maximum_debit_base = " . $this->db->escape($data['maximum_debit_base']) . ",
                    minimum_debit_extra1 = " . $this->db->escape($data['minimum_debit_extra1']) . ",
                    maximum_debit_extra1 = " . $this->db->escape($data['maximum_debit_extra1']) . ",
                    minimum_debit_extra2 = " . $this->db->escape($data['minimum_debit_extra2']) . ",
                    maximum_debit_extra2 = " . $this->db->escape($data['maximum_debit_extra2']) . ",
                    minimum_debit_extra3 = " . $this->db->escape($data['minimum_debit_extra3']) . ",
                    maximum_debit_extra3 = " . $this->db->escape($data['maximum_debit_extra3']) . ",
                    minimum_debit_extra4 = " . $this->db->escape($data['minimum_debit_extra4']) . ",
                    maximum_debit_extra4 = " . $this->db->escape($data['maximum_debit_extra4']) . ",
                    minimum_debit_extra5 = " . $this->db->escape($data['minimum_debit_extra5']) . ",
                    maximum_debit_extra5 = " . $this->db->escape($data['maximum_debit_extra5']) . ",
                    status = " . $this->db->escape($data['status']) . "
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
  
    function edit_dep_methode($data = array())
    {
        if ($data)
        {
            $sql = "
                UPDATE {$this->_db3}
                SET
                    name = " . $this->db->escape($data['name']) . ",
                    fee_fix = " . $this->db->escape($data['fee_fix']) . ",
                    fee = " . $this->db->escape($data['fee']) . ",
                    start_verify = " . $this->db->escape($data['start_verify']) . ",
                    standart_verify = " . $this->db->escape($data['standart_verify']) . ",
                    expanded_verify = " . $this->db->escape($data['expanded_verify']) . ",
                    debit_base = " . $this->db->escape($data['debit_base']) . ",
                    debit_extra1 = " . $this->db->escape($data['debit_extra1']) . ",
                    debit_extra2 = " . $this->db->escape($data['debit_extra2']) . ",
                    debit_extra3 = " . $this->db->escape($data['debit_extra3']) . ",
                    debit_extra4 = " . $this->db->escape($data['debit_extra4']) . ",
                    debit_extra5 = " . $this->db->escape($data['debit_extra5']) . ",
                    minimum_debit_base = " . $this->db->escape($data['minimum_debit_base']) . ",
                    maximum_debit_base = " . $this->db->escape($data['maximum_debit_base']) . ",
                    minimum_debit_extra1 = " . $this->db->escape($data['minimum_debit_extra1']) . ",
                    maximum_debit_extra1 = " . $this->db->escape($data['maximum_debit_extra1']) . ",
                    minimum_debit_extra2 = " . $this->db->escape($data['minimum_debit_extra2']) . ",
                    maximum_debit_extra2 = " . $this->db->escape($data['maximum_debit_extra2']) . ",
                    minimum_debit_extra3 = " . $this->db->escape($data['minimum_debit_extra3']) . ",
                    maximum_debit_extra3 = " . $this->db->escape($data['maximum_debit_extra3']) . ",
                    minimum_debit_extra4 = " . $this->db->escape($data['minimum_debit_extra4']) . ",
                    maximum_debit_extra4 = " . $this->db->escape($data['maximum_debit_extra4']) . ",
                    minimum_debit_extra5 = " . $this->db->escape($data['minimum_debit_extra5']) . ",
                    maximum_debit_extra5 = " . $this->db->escape($data['maximum_debit_extra5']) . ",
                    ac_debit_base = " . $this->db->escape($data['ac_debit_base']) . ",
                    ac_debit_extra1 = " . $this->db->escape($data['ac_debit_extra1']) . ",
                    ac_debit_extra2 = " . $this->db->escape($data['ac_debit_extra2']) . ",
                    ac_debit_extra3 = " . $this->db->escape($data['ac_debit_extra3']) . ",
                    ac_debit_extra4 = " . $this->db->escape($data['ac_debit_extra4']) . ",
                    ac_debit_extra5 = " . $this->db->escape($data['ac_debit_extra5']) . ",
                    api_value1 = " . $this->db->escape($data['api_value1']) . ",
                    api_value2 = " . $this->db->escape($data['api_value2']) . ",
                    status = " . $this->db->escape($data['status']) . "
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

}
