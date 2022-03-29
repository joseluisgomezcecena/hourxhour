<?php

class Site extends CI_Model {

    protected $table = 'site';
    
    public $id;
    //fields
    public $name;
    public $plant_id;

    
    
	public function __construct($id = NULL)
	{
		$this->load->database();
        $this->id = $id;

        if($this->id != NULL)
        {
            $this->loadModel( $this->getData('id', $this->id) );
        }        
	}

    public function loadModel($data)
    {
        $this->name = $data['name'];
        $this->plant_id = $data['plant_id'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }


    public function getRawData()
    {
        $data['name'] = $this->name;
        $data['plant_id'] = $this->plant_id;
        return $data;
    }

	public function getAll()
	{
		$query = $this->db->get('sites');
		return $query->result_array();
	}

    public function Save()
    {
        $now        = date("Y-m-d H:i:s");
        $data = $this->getRawData();
        if($this->id == NULL )
        {
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
            //ES un nuevo registro
            $this->insertData( $data );
        } else
        {
            $data['updated_at'] = $now;
            //Esn un registro existente
            $this->updateData( $data, ['id' => $this->id] );
        }
    }


    public function Delete()
    {
        $this->deleteData(['id' => $this->id]);
    }

}

