<?php



class Plants extends CI_Controller
{
    public function index()
    {

        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $data['title'] = "Plantas";
        $data['plants'] = $this->Plant->getAllActive();
        $this->load->view('templates/header');
        $this->load->view('pages/andon/plants/index', $data);
        $this->load->view('templates/footer');
    }



    public function api_all()
    {
        $this->load->database();
        echo json_encode($this->db->get('plants')->result_array());
    }




    public function create()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $plant_name = $this->input->post('plant_name');

        $data['title'] = "Crear una planta";

        $this->form_validation->set_rules('plant_name', 'Plant Name', 'required');
        $this->form_validation->set_rules('plant_password', 'Plant Password', 'required');


        if (isset($_POST['save_plant'])) {
            if ($this->form_validation->run() === TRUE) {
                $this->db->where('plant_name', $plant_name);
                $query = $this->db->get('plants');
                if ($query->num_rows() > 0) {
                    $data['message_title'] = 'Ups!';
                    $data['message_description'] = 'The plant ' . $plant_name . ' already exists. The name of the Plant cannot be repeated.';
                    $data['message_type'] = 'error';
                } else {
                    //this can be created...
                    $this->Plant->save();
                    $data['message_title'] = 'Se a agregado exitosamente!';
                    $data['message_description'] = 'La planta ' . $plant_name . ' ha sido agregada.';
                    $data['message_type'] = 'success';
                }
            }
        }

        $this->load->view('templates/header');
        $this->load->view('pages/andon/plants/create', $data);
        $this->load->view('templates/footer');
    }


    public function edit($id)
    {

        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $data['title'] = "Actualizar Planta";
        $data['plant'] = $this->Plant->display_single_plant($id);

        if (empty($data['plant'])) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('pages/andon/plants/edit', $data);
        $this->load->view('templates/footer');
    }

    public function confirm_delete($id)
    {
        $data['title'] = "Eliminar Planta";
        $data['plant'] = $this->Plant->display_single_plant($id);

        if (empty($data['plant'])) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('pages/andon/plants/delete', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);


        $plant_id = $this->input->post('id');
        $this->db->where('plant_id', $plant_id);
        $query = $this->db->get('sites');

        if ($query->num_rows() > 0) {
            $data['title'] = "La planta no puede ser eliminada";
            $data['message'] = "Se tiene celdas agregadas en esta planta, por esa raz??n no puede ser eliminada";
            $data['url'] =  base_url() . "plants";
            $this->load->view('pages/errors/includes/header');
            $this->load->view('pages/errors/index', $data);
            $this->load->view('pages/errors/includes/footer');
            return;
        }

        $this->db->where('plant_id', $plant_id);
        $this->db->delete('plants');

        redirect('plants');
    }


    public function update()
    {
        $this->Plant->update();
        redirect('plants');
    }
}
