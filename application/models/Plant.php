<?php

include_once('Base.php');

class Plant extends Base_Model {

    protected $table = 'plant';

    public $plant_id;
    //fields
    public $plant_name;
    public $plant_use_password;
    public $plant_password;
    public $plant_active;
    

	public function __construct($id = NULL)
	{
        parent::__construct();

		$this->load->database();
        $this->plant_id = $id;

        if($this->plant_id != NULL)
        {
            $this->loadModel( $this->getData('plant_id',$this->plant_id) );
        }        
	}

    public function loadModel($data)
    {   
        if(count($data) > 0)
        {
            $item = $data[0];
            $this->plant_name = $item['plant_name'];
            $this->plant_use_password = $item['plant_use_password'];
            $this->plant_password = $item['plant_password'];
            $this->plant_active = $item['plant_active'];
            $this->created_at = $item['created_at'];
            $this->updated_at = $item['updated_at'];
        }
    }


    public function getRawData()
    {
        $data['plant_name'] = $this->plant_name;
        $data['plant_use_password'] = $this->plant_use_password;
        $data['plant_password'] = $this->plant_password;
        $data['plant_active'] = $this->plant_active;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;
        return $data;
    }

    public function Save()
    {
        $result = true;
        $now        = date("Y-m-d H:i:s");
        $data = $this->getRawData();
        if($this->plant_id == NULL )
        {
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
            //ES un nuevo registro
            $id = $this->insertData( $data );

            if($id != false) 
                $this->plant_id = $id;
            else
                $result = false;
            
        } else
        {
            $data['updated_at'] = $now;
            //Esn un registro existente
            $result = $this->updateData( $data, ['plant_id' => $this->plant_id] );
        }

        return $result;
    }


    public function Delete()
    {
        $this->deleteData(['id' => $this->plant_id]);
    }
    

}
