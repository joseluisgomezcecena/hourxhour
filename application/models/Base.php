<?php

include BASEPATH . 'core\\Model.php';

class Base_Model extends CI_Model{

    protected $table = ""; //To override
    

    public $created_at;
    public $updated_at;

	public function __construct()
	{
        parent::__construct();
	}

    public function getData($column_id, $id)
    {
        $this->db->where($column_id, $id);
        $query = $this->db->get(  $this->table );
        $data = $query->result_array();

        //echo json_encode($data);

        return $data;
    }

    public function insertData($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function updateData($data, $where)
    {
        return $this->db->update($this->table, $data, $where);
    }

    public function deleteData($where)
    {
        return $this->db->update($this->table, $where);
    }

}
