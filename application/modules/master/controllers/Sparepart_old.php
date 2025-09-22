<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sparepart extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/Master_Sparepart_model');
    }


    //load note list view
    function index() {
       
        $this->template->rander("sparepart/index");
    }

    function test(){
        $item_info = $this->Master_Sparepart_model->get_details()->result();
        print_r($item_info);
    }

    /* load item modal */

    function modal_form() {
            $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "numeric"
        ));


            $this->load->view('sparepart/modal_form');
    }

    function modal_form_edit() {
        $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

        $view_data['model_info'] = $this->Master_Sparepart_model->get_details($options)->row();
        

        $this->load->view('sparepart/modal_form_edit', $view_data);
    }

    /* add or edit an item */

     function add() {

        $sparepart_data = array(
            "title" => $this->input->post('title'),
            "code" => getCodeId('master_sparepart',"SP"),
            "deskripsi" => $this->input->post('deskripsi'),
            "kuantitas_pembelian" => $this->input->post('kuantitas_pembelian'),
            "price" => $this->input->post('harga'),
            "kuantitas_pengeluaran" => $this->input->post('kuantitas_pengeluaran'),
            "saldo_perlengkapan" => $this->input->post('saldo')
        );

        $sparepart_id = $this->Master_Sparepart_model->save($sparepart_data);
        if ($sparepart_id) {

            $sparepart_info = $this->Master_Sparepart_model->get_details(array("id"=>$sparepart_id))->row();
            echo json_encode(array("success" => true, "id" => $sparepart_info->id, "data" => $this->_make_item_row($sparepart_info), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function save() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $id = $this->input->post('id');

        $sparepart_data = array(
            "title" => $this->input->post('title'),
            "deskripsi" => $this->input->post('deskripsi'),
            "kuantitas_pembelian" => $this->input->post('kuantitas_pembelian'),
            "price" => $this->input->post('harga'),
            "kuantitas_pengeluaran" => $this->input->post('kuantitas_pengeluaran'),
            "saldo_perlengkapan" => $this->input->post('saldo')
        );

        $sparepart_id = $this->Master_Sparepart_model->save($sparepart_data, $id);
        if ($sparepart_id) {
            $options = array("id" => $sparepart_id);
            $sparepart_info = $this->Master_Sparepart_model->get_details($options)->row();
            echo json_encode(array("success" => true, "id" => $sparepart_info->id, "data" => $this->_make_item_row($sparepart_info), 'message' => lang('record_saved')));
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
            if ($this->Master_Sparepart_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Master_Sparepart_model->get_details($options)->row();
                echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Master_Sparepart_model->delete($id)) {
                $item_info = $this->Master_Sparepart_model->get_one($id);
                echo json_encode(array("success" => true, "id" => $item_info->id, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of items, prepared for datatable  */

    function list_data() {

        $list_data = $this->Master_Sparepart_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of item list table */

    private function _make_item_row($data) {
        // $type = $data->unit_type ? $data->unit_type : "";

        return array(
            $data->code,
            $data->title,
            $data->deskripsi,
            $data->kuantitas_pembelian,
            $data->price,
            $data->kuantitas_pengeluaran,
            $data->saldo_perlengkapan,
            modal_anchor(get_uri("master/sparepart/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_sparepart'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/sparepart/delete"), "data-action" => "delete"))
        );
    }

}

/* End of file items.php */
/* Location: ./application/controllers/items.php */