<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consumables extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master_Consumables_model');

        //check permission to access this module
    }

    /* load clients list view */

    function index()
    {

        $view_data['data'] = "";
        $this->template->rander("consumables/index", $view_data);
    }

    /* load client add/edit modal */

    function modal_form()
    {
        //get custom fields
        $this->db->select('nama');
        $view_data['data'] = "";

        $this->load->view('consumables/modal_form', $view_data);
    }
    
    function modal_form_edit()
    {

        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

        $view_data['model_info'] = $this->Master_Consumables_model->get_details($options)->row();



        $this->load->view('consumables/modal_form_edit', $view_data);
    }

    /* insert or update a client */

    function add_consumables()
    {
        validate_submitted_data(array(
            // "code" => "required",
            "name" => "required"

        ));

        $data = array(
            "name" => $this->input->post('name'),
            "code" => $this->input->post('code'),
            "description" => $this->input->post('description'),
            "satuan" => $this->input->post('satuan'),
            "created_at" => get_current_utc_time(),
            "deleted" => 0,
        );

        $save_id = $this->Master_Consumables_model->save($data);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function save()
    {
        $consumables_id = $this->input->post('id');


        validate_submitted_data(array(
            "id" => "numeric",
            "name" => "required"
        ));

        $data = array(
            "name" => $this->input->post('name'),
            "code" => $this->input->post('code'),
            "description" => $this->input->post('description'),
            "satuan" => $this->input->post('satuan'),
            "updated_at" => get_current_utc_time(),
        );

        $save_id = $this->Master_Consumables_model->save($data, $consumables_id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }


    /* delete or undo a client */

    function delete()
    {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Master_Consumables_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Master_Consumables_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of clients, prepared for datatable  */

    function list_data()
    {
        $list_data = $this->Master_Consumables_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of client list  table */

    private function _row_data($id)
    {
        $options = array(
            "id" => $id
        );
        $data = $this->Master_Consumables_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    /* prepare a row of client list table */

    private function _make_row($data)
    {
        $row_data = array(
            // $data->npwp,
            $data->name,
            $data->satuan ?? '-',
            $data->description ?? '-',
        );


        $row_data[] = modal_anchor(get_uri("master/consumables/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => "Edit consumables", "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => "Delete consumables", "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/consumables/delete"), "data-action" => "delete"));

        return $row_data;
    }

    function view()
    {
        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

        $view_data['model_info'] = $this->Master_Consumables_model->get_details($options)->row();



        $this->load->view('consumables/view', $view_data);
    }


}

/* End of file clients.php */
/* Location: ./application/controllers/clients.php */