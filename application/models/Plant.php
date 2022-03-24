<?php

include_once('Base.php');

class Plant extends Base_Model {

    protected $table = 'plant';

    public $plant_id;
    //fields
    public $plant_name;
    public $plant_use_password;
    public $plant_password;
    public $pñlant_active;
    

	public function __construct($id = NULL)
	{
        parent::__construct();

        echo "entering constructor model " . $id;

		$this->load->database();
        $this->id = $id;

        if($this->id != NULL)
        {
            $this->loadModel( $this->getData('plant_id',$this->id) );
        }        
	}

    public function loadModel($data)
    {   
        if(count($data) > 0)
        {
            $item = $data[0];
            $this->plant_name = $item['plant_name'];
            $this->plant_use_pass = $item['plant_use_password'];
            $this->plant_password = $item['plant_password'];
            $this->plant_active = $item['plant_active'];
            $this->created_at = $item['created_at'];
            $this->updated_at = $item['updated_at'];
        }
    }


    public function getRawData()
    {
        $data['plant_name'] = $this->plant_name;
        $data['plant_use_pass'] = $this->plant_use_pass;
        $data['plant_password'] = $this->plant_password;
        $data['plant_active'] = $this->plant_active;
        return $data;
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
        $this->deleteData(['id' => $this->plant_id]);
    }
    

}
