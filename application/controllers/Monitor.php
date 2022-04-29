<?php
class Monitor extends CI_Controller
{

    public function get_data()
    {
        $data = array();
        //monitores, monito
        //$plant_id = $this->input->post('plant_id');
        $site_id = $this->input->get('site_id');

        $this->db->select('*');
        $this->db->from('monitors');
        $this->db->where('site_id', $site_id);
        $monitors = $this->db->get()->result_array();

        for ($m = 0; $m < count($monitors); $m++) {

            $this->db->select('monitors_assets.*, assets.asset_name');
            $this->db->from('monitors_assets');
            $this->db->join('assets', 'monitors_assets.asset_id = assets.asset_id', 'left');
            $this->db->where('monitors_assets.monitor_id', $monitors[$m]['monitor_id']);

            $assets = $this->db->get()->result_array();
            $monitors[$m]['assets'] = $assets;
        }
        $data['monitors'] = $monitors;


        $this->db->select('*');
        $this->db->from('assets');
        $this->db->where('site_id', $site_id);
        $assets = $this->db->get()->result_array();
        $data['assets'] = $assets;

        echo json_encode($data);
    }


    public function insert_monitor()
    {
        $site_id = $this->input->post('site_id');
        $monitor_name = $this->input->post('monitor_name');
        //monitor_name, site_id
        $data = array(
            'monitor_name' => $monitor_name,
            'site_id' => $site_id,
        );
        $this->db->insert('monitors', $data);
        $data['monitor_id'] = $this->db->insert_id();
        $result['response'] = 'ok';
        $result['data'] = $data;
        echo json_encode($result);
    }


    public function delete_monitor()
    {
        $monitor_id = $this->input->post('monitor_id');

        $this->db->where('monitor_id', $monitor_id);
        $this->db->delete('monitors_assets');

        $this->db->where('monitor_id', $monitor_id);
        $this->db->delete('monitors');

        $result['response'] = 'ok';
        echo json_encode($result);
    }



    public function insert_asset()
    {
        $monitor_id = $this->input->post('monitor_id');
        $asset_id = $this->input->post('asset_id');

        $data = array(
            'monitor_id' => $monitor_id,
            'asset_id' => $asset_id,
        );
        $this->db->insert('monitors_assets', $data);
        $data['monitor_asset_id'] = $this->db->insert_id();
        $result['response'] = 'ok';
        $result['data'] = $data;
        echo json_encode($result);
    }


    public function delete_asset()
    {
        $monitor_asset_id = $this->input->post('monitor_asset_id');
        $this->db->where('monitor_asset_id', $monitor_asset_id);
        $this->db->delete('monitor_assets');
        $result['response'] = 'ok';
        echo json_encode($result);
    }
}
