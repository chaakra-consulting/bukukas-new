<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produksi extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Produksi_model');
        //$this->load->model('master/Master_Warehouse_model');
        //$this->load->model('master/Master_Items_model');
    }


    //load note list view
    function index() {
		
		$data['judul']="PRODUKSI";
        $this->template->rander("produksi/index",$data);
    }

    //load note list view
    function tambah() {
		
		$data['judul']="TAMBAH PRODUKSI";
        $this->template->rander("produksi/view-tambah",$data);
    }

    function getId($id){

        if(!empty($id)){
            $options = array(
                "id" => $id,
            );
            $data = $this->Produksi_model->get_details($options)->row();

            echo json_encode(array("success" => true,"data" => $data));
        }else{
            echo json_encode(array('success' => false,'message' => lang('error_occurred')));
        }
    }

    /* load item modal */

    function modal_form() {

        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();
        //$view_data['data_items'] = $this->Master_Items_model->getItemsDrop();
        $this->load->view('produksi/modal_form',$view_data);
    }

    function item_modal_form($id) {

        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();
        $view_data['data_bahan'] = $this->Produksi_model->persedian_material();
        $view_data['id'] = $id;
        $this->load->view('produksi/item_modal_form',$view_data);
    }

    function jadi_modal_form($id) {

        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();
        $view_data['data_item_jadi'] = $this->Produksi_model->master_item();
        $view_data['id'] = $id;
        $this->load->view('produksi/jadi_modal_form',$view_data);
    }

    function modal_bahan_form_edit($id) {

	
        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

        //$view_data['model_info'] = $this->Produksi_model->get_details_bahan($options)->row();

        //$this->load->view('produksi/modal_form_edit', $view_data);
		
        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();
        //$view_data['data_bahan'] = $this->Produksi_model->persedian_material();
        $view_data['id'] = $id;
        $this->load->view('produksi/modal_bahan_form_edit',$view_data);
    }

    function modal_form_edit() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );

        $view_data['model_info'] = $this->Produksi_model->get_details($options)->row();

        $this->load->view('produksi/modal_form_edit', $view_data);
    }

    /* add or edit an item */

     function add() {
		//echo "apa";
		validate_submitted_data(array(
            // "code" => "required",
            "tanggal" => "required", 
            "deskripsi" => "required"

        ));


        $item_data = array(
			"code" => getCodeId('produksi',"PR"),  
            "pr_tanggal" => $this->input->post('tanggal'),
            "pr_keterangan" => $this->input->post('deskripsi'),
			"pr_createdby" => $this->session->userdata('user_name'),
            "pr_inputdata" => get_current_utc_time(),
            "deleted" =>0,
        );
		//print_r($item_data);
        
		$data = $this->Produksi_model->save($item_data);
        if ($data) {
            //$item_info = $this->Produksi_model->get_details()->row();
			$item_info = $this->Produksi_model->get_maxi()->row();
            echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
		//echo "aa";
    }

     function addbahan() {
		//echo "apa";
		validate_submitted_data(array(
            // "code" => "required",
            "id" => "required", 
            "jumlah" => "required",
            "bahan" => "required"

        ));


		$idd= $this->input->post('id');
		$jumlahQ=$this->input->post('jumlah');
		$bahanQ=$this->input->post('bahan');
		
        $item_data = array(
			//"code" => getCodeId('produksi',"PR"),  
            "pb_produksi_id" => $idd,
            "pb_qty" => $jumlahQ,
            "pb_material_id" => $bahanQ,
			"pb_createdby" => $this->session->userdata('user_name'),
            "pb_timecreated" => get_current_utc_time(),
            "deleted" =>0,
        );
		//print_r($item_data); 
		$data = $this->Produksi_model->simpan_bahan($item_data);
		
		//Item Dikurangi Ditambah
		$datapersediaan=$this->Produksi_model->pilih_material($bahanQ);
		$saldoMaterial=$datapersediaan[0]->pm_saldo_material;
		$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;
		$saldoMatUpd=$saldoMaterial-$jumlahQ;
		$saldoKelUpd=$saldoKeluar+$jumlahQ;
		
        $item_material_update = array(
			//"code" => getCodeId('produksi',"PR"),  
            "pm_saldo_material" => $saldoMatUpd,
            "pm_kuantitas_keluar" => $saldoKelUpd,   
        );
		$updatepersediaan=$this->Produksi_model->update_material($item_material_update,$bahanQ);
		
		
        if ($data) {
            $item_info = $this->Produksi_model->get_details()->row();
            echo json_encode(array("success" => true, "id" => $idd, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
		//echo "aa";
    }

     function addjadi() {
		//echo "apa";
		validate_submitted_data(array(
            // "code" => "required",
            "id" => "required", 
            "jumlah" => "required",
            "harga" => "required",
            "bahan" => "required"

        ));


		$idd= $this->input->post('id');
		$jumlahQ=$this->input->post('jumlah');
		$bahanQ=$this->input->post('bahan');
		$hargaQ=$this->input->post('harga');
		$gudangQ=$this->input->post('gudang');
		
        $item_data = array(
			//"code" => getCodeId('produksi',"PR"),  
            "bj_produksi_id" => $idd, 
            "bj_kategori" => $bahanQ,
            "bj_qty" => $jumlahQ,
            "bj_harga" => $hargaQ,
            "bj_gudang" => $gudangQ,
			"bj_createdby" => $this->session->userdata('user_name'),
            "bj_timecreated" => get_current_utc_time(),
            "deleted" =>0,
        );
		//print_r($item_data); 
		$data = $this->Produksi_model->simpan_jadi($item_data);
		
		/*
		//Item Dikurangi Ditambah
		$datapersediaan=$this->Produksi_model->pilih_material($bahanQ);
		$saldoMaterial=$datapersediaan[0]->pm_saldo_material;
		$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;
		$saldoMatUpd=$saldoMaterial-$jumlahQ;
		$saldoKelUpd=$saldoKeluar+$jumlahQ;
		
        $item_material_update = array(
			//"code" => getCodeId('produksi',"PR"),  
            "pm_saldo_material" => $saldoMatUpd,
            "pm_kuantitas_keluar" => $saldoKelUpd,   
        );
		$updatepersediaan=$this->Produksi_model->update_material($item_material_update,$bahanQ);
		*/
		
        if ($data) {
            $item_info = $this->Produksi_model->get_details()->row();
            echo json_encode(array("success" => true, "id" => $idd, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));
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
		
		$codeprod=getCodeId('produksi',"PR");
		
         $item_data = array( 
            "code" => $codeprod,
            "pr_tanggal" => $this->input->post('tanggal'),
            "pr_keterangan" => $this->input->post('deskripsi'), 
            "pr_createdby" => $this->session->userdata('user_name'), 
            "pr_inputdata" => get_current_utc_time(),
            "deleted" =>0, 
        );
         //print_r($item_data);exit();
        $data = $this->Produksi_model->save($item_data, $id);
		
		
		
		
		
        //echo $this->db->last_query();exit();
        if ($data) {
            $options = array("id" => $data);
            $item_info = $this->Produksi_model->get_details($options)->row();
            echo json_encode(array("success" => true, "id" => $data, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }



	
    function view($id= 0,$hal=FALSE){
        
        if ($id) {
				//echo $id;
            $view_data = get_detail_produksi($id);
			
            if ($view_data) {
                $view_data['hal_aktif'] = $hal;
                $view_data['data_detail'] = $view_data;
                
                //$view_data['invoice_status_label'] = $this->_get_order_status_label($view_data["invoice_info"]);
					
                $this->template->rander("produksi/view", $view_data);
            } else {
                show_404();
            }
        }else{
            show_404();
        }
    }


    /* delete or undo an item */

    function delete() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Produksi_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Produksi_model->get_details($options)->row();
                echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Produksi_model->delete($id)) {
                $item_info = $this->Produksi_model->get_one($id);
                echo json_encode(array("success" => true, "id" => $item_info->id, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }
	
	
    function deletebahan() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
    
		$databa=$this->Produksi_model->get_details_bahan(array('pb.id'=>$id))->result();
		//print_r($databa);
		//echo "window.alert('".$databa."')";
		
		if(count($databa)>0){
			
			$bahanQ=$databa[0]->pb_material_id;
			$jumlahQ=$databa[0]->pb_qty;
			if($bahanQ!=''){
				//Item Dikurangi Ditambah
				$datapersediaan=$this->Produksi_model->pilih_material($bahanQ);
				$saldoMaterial=$datapersediaan[0]->pm_saldo_material;
				$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;
				$saldoMatUpd=$saldoMaterial+$jumlahQ;
				$saldoKelUpd=$saldoKeluar-$jumlahQ;
				
				$item_material_update = array(
					//"code" => getCodeId('produksi',"PR"),  
					"pm_saldo_material" => $saldoMatUpd,
					"pm_kuantitas_keluar" => $saldoKelUpd,   
				);
				$updatepersediaan=$this->Produksi_model->update_material($item_material_update,$bahanQ);
				//$upoke=TRUE;
			}
			
			 
				if ($this->Produksi_model->deleteBahan($id)) {
					//$item_info = $this->Produksi_model->get_one($id);
					
					
					
					echo json_encode(array("success" => true, "id" => '', 'message' => lang('record_deleted')));
					//echo json_encode(array("success" => true, "id" => '', 'message' => lang('record_deleted')));
				} else {
					echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
				}
		}else {
					echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
				}
    }

    function deletebarangjadi() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
         
            if ($this->Produksi_model->deleteBarangjadi($id)) {
                //$item_info = $this->Produksi_model->get_one($id);
                echo json_encode(array("success" => true, "id" => '', 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            } 
    }

    /* list of items, prepared for datatable  */

	     //prepare invoice status label 
     private function _get_order_status_label($invoice_info, $return_html = true) {
        // return get_order_status_label($data, $return_html);
        $invoice_status_class = "label-default";
        $status = "draft";
        $now = get_my_local_time("Y-m-d");
        if ($invoice_info->status == "draft" ) {
            $invoice_status_class = "label-warning";
            $status = "Draft";
        } else if ($invoice_info->status == "sent") {
            $invoice_status_class   = "label-success";
            $status = "Sudah Terkirim";

        }
        $invoice_status = "<span class='label $invoice_status_class large'>" . $status . "</span>";
        if ($return_html) {
            return $invoice_status;
        } else {
            return $status;
        }
    }

	
    function list_data() {

        $list_data = $this->Produksi_model->get_details()->result();
		//$this->db->error();
        $result = array();
        $before='';
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row($data,$before);
            $before=$data->code;
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of item list table */

    private function _make_item_row($data,$before) {
        // $type = $data->unit_type ? $data->unit_type : "";

        $name=$data->code;
        //$code=$data->code;
        if($data->code==$before){
            $name='';
        }
		
        $row_data = array( 
			$name,
			$data->pr_tanggal,
            $data->pr_keterangan, 

        );

		$row_data[] = anchor(get_uri("inventory/produksi/view/".$data->id), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id));
            //. js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/produksi/delete"), "data-action" => "delete"));
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
            $data->pm_saldo_produksi,
           // $data->pm_saldo_produksi,
            modal_anchor(get_uri("inventory/produksi/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/produksi/delete"), "data-action" => "delete"))
        );
		
		*/
    }
	
	
    function item_list_data_bahan($invoice_id = 0) {

        $list_data = $this->Produksi_model->produksi_bahan(array("pb_produksi_id" => $invoice_id,"pb.deleted" => 0))->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row_bahan($data);
        }
        echo json_encode(array("data" => $result));
        // $this->output->enable_profiler(TRUE);
        // print_r($list_data);

    }
	
    private function _make_item_row_bahan($data,$before) {
        // $type = $data->unit_type ? $data->unit_type : "";

        $bid=$data->pib;
        $name=$data->code;
        //$code=$data->code;
        if($data->code==$before){
            $name='';
        }
		
        $row_data = array( 
			 $data->pm_deskripsi,
            $data->pb_qty.'(m3)',  

        );

		//$row_data[] = modal_anchor(get_uri("inventory/produksi/modal_bahan_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))
          //  . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/produksi/deletebahan"), "data-action" => "delete"));
            $row_data[] = js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $bid, "data-action-url" => get_uri("inventory/produksi/deletebahan"), "data-action" => "delete"));

        return $row_data;

    }
	
    function updatebahan() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $id = $this->input->post('id');
		
		//$codeprod=getCodeId('produksi',"PR");
		
         $item_data = array( 
            //"code" => $codeprod,
            "pb_qty" => $this->input->post('jumlah'),
        );
         //print_r($item_data);exit();
        $data = $this->Produksi_model->updatebahan($item_data, $id);
		
        //echo $this->db->last_query();exit();
        if ($data) {
            $options = array("id" => $data);
            //$item_info = $this->Produksi_model->get_details($options)->row();
            echo json_encode(array("success" => true, "id" => $data, "data" => $this->_make_item_row_bahan($item_info), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

	
    function item_list_data_barangjadi($invoice_id = 0) {

        $list_data = $this->Produksi_model->produksi_barangjadi(array("bj_produksi_id" => $invoice_id,"bj.deleted" => 0))->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row_barangjadi($data);
        }
        echo json_encode(array("data" => $result));
        // $this->output->enable_profiler(TRUE);
        // print_r($list_data);

    }
	
    private function _make_item_row_barangjadi($data,$before) {
        // $type = $data->unit_type ? $data->unit_type : "";

        $bid=$data->bid;
        $name=$data->code;
        //$code=$data->code;
        if($data->code==$before){
            $name='';
        }
		
        $row_data = array( 
			 $data->title, 
			 $data->bj_qty, 
			 $data->bj_harga,
			 $data->bj_gudang, 

        );

		$row_data[] = js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $bid, "data-action-url" => get_uri("inventory/produksi/deletebarangjadi"), "data-action" => "delete"));
		//$row_data[] = modal_anchor(get_uri("inventory/produksi/modal_barangjadi_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))
        //    . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/produksi/deletebarangjadi"), "data-action" => "delete"));

        return $row_data;

    }


}

/* End of file produksi.php */
/* Location: ./application/controllers/produksi.php */