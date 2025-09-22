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

    //load note list view
    function page($menu) {
       if($menu=="oli"){
		   $data['menu']="oli";
		   $this->template->rander("sparepart/index_page",$data);
	   }elseif($menu=="solar"){
		   
		   $data['menu']="solar";
		   $this->template->rander("sparepart/index_page",$data);
	   }else{
		   $this->template->rander("sparepart/index");
	   }
        
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

    function modal_form_page($menu) {
            $this->access_only_admin();
		$data['menu']=$menu;
        validate_submitted_data(array(
            "id" => "numeric"
        ));


            $this->load->view('sparepart/modal_form_page',$data);
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
    function modal_form_edit_page($menu) {
		
        $this->access_only_admin();

		$view_data['menu']=$menu;
		
        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

		if($menu=="oli"){
			$view_data['model_info'] = $this->Master_Sparepart_model->get_details_oli($options)->row();
		}elseif($menu=="solar"){
			$view_data['model_info'] = $this->Master_Sparepart_model->get_details_solar($options)->row();
		}else{
			$view_data['model_info'] = $this->Master_Sparepart_model->get_details($options)->row();
		}
        
        

        $this->load->view('sparepart/modal_form_edit_page', $view_data);
    }

    /* add or edit an item */

     function add() {
		$tipekat=$this->input->post('tipe_kategori');
		if($tipekat=="0"){
			$thcode="SP";
		}elseif($tipekat=="1"){
			$thcode="OL";
		}elseif($tipekat=="2"){
			$thcode="SO";
		}else{
			$thcode="SP";
		}
		
        $sparepart_data = array(
            "title" => $this->input->post('title'),
            "code" => getCodeId('master_sparepart',$thcode),
            "deskripsi" => $this->input->post('deskripsi'),
            "type_category" => $tipekat,
            "kuantitas_pembelian" => $this->input->post('kuantitas_pembelian'),
            "price" => $this->input->post('harga'),
            "kuantitas_pengeluaran" => $this->input->post('kuantitas_pengeluaran'),
            "saldo_perlengkapan" => $this->input->post('saldo')
        );

        $sparepart_id = $this->Master_Sparepart_model->save($sparepart_data);
        if ($sparepart_id) {
			if($tipekat=="1"){
				$sparepart_info = $this->Master_Sparepart_model->get_details_oli(array("id"=>$sparepart_id))->row();
			}elseif($tipekat=="2"){
				$sparepart_info = $this->Master_Sparepart_model->get_details_solar(array("id"=>$sparepart_id))->row();
			}else{
				$sparepart_info = $this->Master_Sparepart_model->get_details(array("id"=>$sparepart_id))->row();
			}
			 
            
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


    function savepage($page) {

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
            if($page=="oli"){
				$sparepart_info = $this->Master_Sparepart_model->get_details_oli($options)->row();
			}elseif($page=="solar"){
				$sparepart_info = $this->Master_Sparepart_model->get_details_solar($options)->row();
			}else{
				$sparepart_info = $this->Master_Sparepart_model->get_details($options)->row();
			}
			
			
            echo json_encode(array("success" => true, "id" => $sparepart_info->id, "data" => $this->_make_item_row_page($sparepart_info,$page), 'message' => lang('record_saved')));
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

    /* delete or undo an item */

    function delete_page($page) {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Master_Sparepart_model->delete($id, true)) {
                $options = array("id" => $id);
				
				if($page=="oli"){
					$item_info = $this->Master_Sparepart_model->get_details_oli($options)->row();
				}elseif($page=="solar"){
					$item_info = $this->Master_Sparepart_model->get_details_solar($options)->row();
				}else{
					$item_info = $this->Master_Sparepart_model->get_details($options)->row();
				}
                
				
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

    /* list of items data, prepared for datatable  */

    function list_data_page($menu) {
		$page=$menu;
		if($menu=="oli"){
			$list_data = $this->Master_Sparepart_model->get_details_oli()->result();	
		}elseif($menu=="solar"){
		
			$list_data = $this->Master_Sparepart_model->get_details_solar()->result();		
		}else{
			
			$list_data = $this->Master_Sparepart_model->get_details()->result();
		}
		
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row_page($data,$page);
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
    private function _make_item_row_page($data,$page) {
        // $type = $data->unit_type ? $data->unit_type : "";

        return array(
            $data->code,
            $data->title,
            $data->deskripsi,
            $data->kuantitas_pembelian,
            $data->price,
            $data->kuantitas_pengeluaran,
            $data->saldo_perlengkapan,
            modal_anchor(get_uri("master/sparepart/modal_form_edit_page/".$page), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => "Ubah ".ucfirst($page), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/sparepart/delete_page/".$page), "data-action" => "delete"))
        );
    }

}

/* End of file items.php */
/* Location: ./application/controllers/items.php */