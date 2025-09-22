<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kode_kas extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/Master_Kode_model');
    
    }


    //load note list view
    function index() {
        
        $this->template->rander("kode/index");
    }

    /* load item modal */

    function modal_form() {
        $this->load->view('kode/modal_form', $view_data);
    }

    function getId($id){

        if(!empty($id)){
            $options = array(
                "id" => $id,
            );
            $data = $this->Master_Kode_model->get_details($options)->row();

            echo json_encode(array("success" => true,"data" => $data));
        }else{
            echo json_encode(array('success' => false,'message' => lang('error_occurred')));
        }
    }
    
    function modal_form_edit() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));
       $view_data['model_info'] = $this->Master_Kode_model->get_one($this->input->post('id'));

 
        $this->load->view('kode/modal_form_edit', $view_data);
    }

    /* add or edit an item */

     function add() {
        validate_submitted_data(array(
                "code" => "required",
                "name" => "required"
            ));

            $kode_data = array(
                "code" => $this->input->post('code'),
                "name" => $this->input->post('name'),
                "area" => $this->input->post('area'), 
        );

        $save_id = $this->Master_Kode_model->save($kode_data);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function save() {
        $id = $this->input->post('id');
        validate_submitted_data(array(
            "code" => "required",
            "name" => "required"
        ));

        $kode_data = array(
            "code" => $this->input->post('code'),
            "name" => $this->input->post('name'),
            "area" => $this->input->post('area'), 
        );

        $save_id = $this->Master_Kode_model->save($kode_data, $id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }



    /* delete or undo an item */

    function delete() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Master_Kode_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Master_Kode_model->get_details($options)->row();
                echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_row_data($item_info), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Master_Kode_model->delete($id)) {
                $item_info = $this->Master_Kode_model->get_one($id);
                echo json_encode(array("success" => true, "id" => $item_info->id, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of kode, prepared for datatable  */

    function list_data() {

        $list_data = $this->Master_Kode_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_row_data($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of item list table */

    private function _row_data($data) {
        // $type = $data->unit_type ? $data->unit_type : "";
        $row_data = array(  
            $data->code,
            $data->name,
            $data->area
        );
            $row_data[] = modal_anchor(get_uri("master/kode_kas/view"), "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id)).
            modal_anchor(get_uri("master/kode_kas/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/kode_kas/delete"), "data-action" => "delete"));
            
        
        return $row_data;
    }

    public function detail($id){
        $this->load->model('master/Master_Kode_model');
        $detail = $this->Master_Kode_model->detail_data($id);
        $data['detail'] = $detail;
        $result = array();
       
    
     
        $this->load->view('kode/detail');
        $this->template->rander("kode_kas/detail", $view_data);
    }

    function view(){
        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

        $view_data['model_info'] = $this->Master_Kode_model->get_details($options)->row();

        

        $this->load->view('kode/view', $view_data);
    }
    }


/* End of file kode.php */
/* Location: ./application/controllers/kode.php */