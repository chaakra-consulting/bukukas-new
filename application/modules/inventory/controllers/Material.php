<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Material extends MY_Controller {



    function __construct() {

        parent::__construct();

        $this->load->model('Persediaan_model');

        $this->load->model('Produksi_model');

        //$this->load->model('master/Master_Warehouse_model');

        //$this->load->model('master/Master_Items_model');

    }





    //load note list view

    function index() {

		

		$data['judul']="Material Persediaan";

        $this->template->rander("material/index",$data);

    }



    function getId($id){



        if(!empty($id)){

            $options = array(

                "id" => $id,

            );

            $data = $this->Persediaan_model->get_details($options)->row();



            echo json_encode(array("success" => true,"data" => $data));

        }else{

            echo json_encode(array('success' => false,'message' => lang('error_occurred')));

        }

    }



    /* load item modal */



    function modal_form() {



        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();

        //$view_data['data_items'] = $this->Master_Items_model->getItemsDrop();

        $view_data['data_item_jadi'] = $this->Produksi_model->master_item();

        $view_data['id'] = $id;

        $this->load->view('material/modal_form',$view_data);

    }



    function modal_form_edit() {



        validate_submitted_data(array(

            "id" => "numeric"

        ));





        $id = $this->input->post('id');

        $options = array(

            "id" => $id,

        );



        $view_data['model_info'] = $this->Persediaan_model->get_details($options)->row();
        $view_data['data_item_jadi'] = $this->Produksi_model->master_item();

        $view_data['id'] = $id;


        $this->load->view('material/modal_form_edit', $view_data);

    }



    /* add or edit an item */



     function add() {

		//echo "apa";

		validate_submitted_data(array(

            // "code" => "required",

            //"nomor" => "required",

            "deskripsi" => "required"



        ));





        $item_data = array(

			"code" => getCodeId('persedian_material',"PM"), 

            "pid_items" => $this->input->post('barang'),

            "pm_tanggal_masuk" => $this->input->post('tanggal'),

            "pm_deskripsi" => $this->input->post('deskripsi'),

            "pm_kuantitas_pembelian" => $this->input->post('kuantitasbeli'),

            "pm_unit_harga" => $this->input->post('harga'),

            "pm_kuantitas_keluar" => $this->input->post('kuantitasprod'), 

            "pm_saldo_material" => $this->input->post('saldo'), 

            "pm_created_by" => $this->session->userdata('user_name'),

            "pm_updated_by" => $this->session->userdata('user_name'), 

            "pm_tanggal" => get_current_utc_time(),

            "deleted" =>0,

            "pm_status" =>0,

        );

		//print_r($item_data);

        

		$data = $this->Persediaan_model->save($item_data);

        if ($data) {

            $item_info = $this->Persediaan_model->get_details()->row();

            echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));

        } else {

            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));

        }

		//echo "aa";

    }



    function save() {



        validate_submitted_data(array(

            "id" => "numeric"

        ));



        $id = $this->input->post('id');



         $item_data = array(

            "pm_nomor" => $this->input->post('nomor'),

            "pid_items" => $this->input->post('barang'),

            "pm_tanggal_masuk" => $this->input->post('tanggal'),

            "pm_deskripsi" => $this->input->post('deskripsi'),

            "pm_kuantitas_pembelian" => $this->input->post('kuantitasbeli'),

            "pm_unit_harga" => $this->input->post('harga'),

            "pm_kuantitas_keluar" => $this->input->post('kuantitasprod'), 

            "pm_saldo_material" => $this->input->post('saldo'), 

            "pm_created_by" => $this->session->userdata('user_name'),

            "pm_updated_by" => $this->session->userdata('user_name'), 

            "pm_tanggal" => get_current_utc_time(),

            "deleted" =>0,

            "pm_status" =>0,



        );



         //print_r($item_data);exit();



        $data = $this->Persediaan_model->save($item_data, $id);

        //echo $this->db->last_query();exit();

        if ($data) {

            $options = array("id" => $data);

            $item_info = $this->Persediaan_model->get_details($options)->row();

            echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));

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

            if ($this->Persediaan_model->delete($id, true)) {

                $options = array("id" => $id);

                $item_info = $this->Persediaan_model->get_details($options)->row();

                echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), "message" => lang('record_undone')));

            } else {

                echo json_encode(array("success" => false, lang('error_occurred')));

            }

        } else {

            if ($this->Persediaan_model->delete($id)) {

                $item_info = $this->Persediaan_model->get_one($id);

                echo json_encode(array("success" => true, "id" => $item_info->id, 'message' => lang('record_deleted')));

            } else {

                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));

            }

        }

    }



    /* list of items, prepared for datatable  */



    function list_data() {



        $list_data = $this->Persediaan_model->get_details()->result();

		//$this->db->error();

        $result = array();

        $before='';

        foreach ($list_data as $data) {

            $result[] = $this->_make_item_row($data,$before);

            $before=$data->pm_nomor;

        }

        echo json_encode(array("data" => $result));

    }



    /* prepare a row of item list table */



    private function _make_item_row($data,$before) {

        // $type = $data->unit_type ? $data->unit_type : "";



        $name=$data->pm_nomor;

        $code=$data->code;

        if($data->pm_nomor==$before){

            $name='';

        }

        else if($data->code==$before){

            $code='';

        }

        $originalDate = $data->pm_tanggal_masuk;
            
        $newDate = date("d-m-Y", strtotime($originalDate));

		

        $row_data = array(

            $code,

            $newDate,

            $data->title,

			$data->pm_deskripsi,

            $data->pm_kuantitas_pembelian,

            $data->pm_kuantitas_keluar,

            $data->pm_saldo_material,



        );



		$row_data[] = modal_anchor(get_uri("inventory/material/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))

            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/material/delete"), "data-action" => "delete"));

//        $row_data[] = modal_anchor(get_uri("master/customers/view"), "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id)).modal_anchor(get_uri("master/customers/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => "Edit Customers", "data-post-id" => $data->id))

  //              . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => "Delete Customers", "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/customers/delete"), "data-action" => "delete"));



        return $row_data;

/*



        return array(

            $name,

            $data->pm_deskripsi,

            $data->pm_kuantitas_pembelian,

            $data->pm_unit_harga,

            $data->pm_kuantitas_keluar,

            $data->pm_saldo_material,

           // $data->pm_saldo_material,

            modal_anchor(get_uri("inventory/material/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))

            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/material/delete"), "data-action" => "delete"))

        );

		

		*/

    }



}



/* End of file material.php */

/* Location: ./application/controllers/material.php */