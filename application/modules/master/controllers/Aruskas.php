<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aruskas extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/Master_Aruskas_model');
        $this->load->model('master/Master_Kode_model');
        // $this->load->model('');
    }

    public function index() {    

        $this->template->rander("aruskas/index");
    }
    function getId($id){

        if(!empty($id)){
            $kas = array(
                "id" => $id,
            );
            $data = $this->Master_Kode_model->get_details($kas)->row();

            echo json_encode(array("success" => true,"data" => $data));
        }else{
            echo json_encode(array('success' => false,'message' => lang('error_occurred')));
        }
    }

    /* open new member modal */

    function modal_form() {
        
        $view_data['kode_dropdown'] = array("" => "-") + $this->Master_Kode_model->get_dropdown_list(array("code","name","area"));
        
        $this->load->view('aruskas/modal_form', $view_data);
    }

    function modal_form_edit() {
    
        validate_submitted_data(array(
            "id" => "numeric"
        ));
        $id = $this->input->post('id');
        $kas = array(
            "id" => $id,
        );
        $view_data['kode_dropdown'] = array("" => "-") + $this->Master_Kode_model->get_dropdown_list(array("code","name","area"));
        $view_data['model_info'] = $this->Master_Aruskas_model->get_one($this->input->post('id'));

        

        $this->load->view('aruskas/modal_form_edit', $view_data);
    }

    /* save new member */

    function add_kas() {

        validate_submitted_data(array(
            "code_kas" => "required"
        ));

        $data = array(
            "code_kas" => $this->input->post('code_kas'),
            "name_code" => $this->input->post('name_code'),
            "area_code" => $this->input->post('area_code'),
            "tgl" => $this->input->post('tgl'),
            "ref" => $this->input->post('ref'),
            "uraian" => $this->input->post('uraian'),
            "debet" => $this->input->post('debet'),
            "kredit" => $this->input->post('kredit'),
            "ket" => $this->input->post('ket')

        );
        //add a new team member
        $kas = $this->Master_Aruskas_model->save($data);
        
        if ($kas) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($kas), 'id' => $kas, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function save() {
        $id = $this->input->post('id');
        $debet = unformat_currency($this->input->post('debet'));
        $kredit = unformat_currency($this->input->post('kredit'));

        validate_submitted_data(array(
            "id" => "numeric",
            "code_kas" => "required"
        ));
        $data = array(
            "code_kas" => $this->input->post('code_kas'),
            "name_code" => $this->input->post('name_code'),
            "area_code" => $this->input->post('area_code'),
            "tgl" => $this->input->post('tgl'),
            "ref" => $this->input->post('ref'),
            "uraian" => $this->input->post('uraian'),
            "debet" => unformat_currency($this->input->post('debet')),
            "kredit" => unformat_currency($this->input->post('kredit')),
            "ket" => $this->input->post('ket'),
        );

        $save_id = $this->Master_Aruskas_model->save($data, $id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* open invitation modal */

    

    //prepere the data for members list
    function list_data() {
       
        $list_data = $this->Master_Aruskas_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row data for member list
    function _row_data($id) {
        $kas = array(
            "id" => $id
        ); 
        
        $data = $this->Master_Aruskas_model->get_details($kas)->row();
        return $this->_make_row($data);
    }

    //prepare team member list row
    private function _make_row($data) {
        $options = array(
            "id" => $data->code_kas
        );
        $query = $this->Master_Kode_model->get_details($options)->row();
        $originalDate = $data->tgl;
        $newDate = date("d-M-Y", strtotime($originalDate));
        $row_data = array(
            $originalDate,
            $data->ref,
            modal_anchor(get_uri("master/kode_kas/view/" . $data->code_kas), $query->code, array("class" => "view", "title" => "Kode Kas ".$query->code, "data-post-id" => $data->code_kas)),
            $data->name_code,
            $data->area_code,
            $data->uraian,
            to_currency ($data->debet),
            to_currency ($data->kredit),
            $data->ket
            // $data->credit_limit,
           
        );

        
        $delete_link = "";
        if ($this->login_user->is_admin) {
            $delete_link = js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_kas'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/perusahaan/delete"), "data-action" => "delete-confirmation"));
        }

        $row_data[] = modal_anchor(get_uri("master/aruskas/view"), "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id))
        .modal_anchor(get_uri("master/aruskas/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => 'Edit Kas', "data-post-id" => $data->id)).$delete_link;

        return $row_data;
    }

    //delete a team member
    function delete() {
        $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
      
        if ($id != $this->login_user->id && $this->Master_Aruskas_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
        }
    }

    function view(){
        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );
        $view_data['kode_dropdown'] = array("" => "-") + $this->Master_Kode_model->get_dropdown_list(array("code"));

        $view_data['model_info'] = $this->Master_Aruskas_model->get_details($options)->row();

        

        $this->load->view('aruskas/view', $view_data);
    }



}

/* End of file team_member.php */
/* Location: ./application/controllers/team_member.php */