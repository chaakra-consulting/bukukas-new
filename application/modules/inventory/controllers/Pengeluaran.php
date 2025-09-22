<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Pengeluaran extends MY_Controller {



    function __construct() {

        parent::__construct();

        $this->load->model('Pengeluaran_model');

        //$this->load->model('master/Master_Warehouse_model');

        //$this->load->model('master/Master_Items_model');

    }





    //load note list view

    function index() {

		

		$data['judul']="Pengeluaran";

        $this->template->rander("pengeluaran/index",$data);

    }



    //load note list view

    function tambah() {

		

		$data['judul']="Tambah Pengeluaran";

        $this->template->rander("pengeluaran/view-tambah",$data);

    }



    function getId($id){



        if(!empty($id)){

            $options = array(

                "id" => $id,

            );

            $data = $this->Pengeluaran_model->get_details($options)->row();



            echo json_encode(array("success" => true,"data" => $data));

        }else{

            echo json_encode(array('success' => false,'message' => lang('error_occurred')));

        }

    }



    /* load item modal */



    function modal_form() {



        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();

        //$view_data['model_info'] = $this->Master_Items_model->getItemsDrop();

        $this->load->view('pengeluaran/modal_form',$view_data);

    }



    function item_modal_form($id) {



        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();

        //$view_data['data_bahan'] = $this->Pengeluaran_model->persedian_material();

        $view_data['id'] = $id;

        $this->load->view('pengeluaran/item_modal_form',$view_data);

    }



    function save_item() {



        validate_submitted_data(array(

            "id" => "numeric",

            //"invoice_id" => "required|numeric"

        ));



        //$invoice_id = $this->input->post('invoice_id');

        $invoice_id = $this->input->post('id');



        $id = $this->input->post('id');

        //$rate = unformat_currency($this->input->post('invoice_item_rate'));

        $quantity = unformat_currency($this->input->post('invoice_item_quantity'));

		//$tipe=$this->input->post('unit_type');

		$tipe='';

		$kode=$this->input->post('kode_produk');

        $invoice_item_data = array(

            "fid_pengeluaran" => $invoice_id,

            "kode" => $kode,

            "title" => $this->input->post('invoice_item_title'),

            "description" => $this->input->post('description'),

            "category" => $this->input->post('category'),

            "quantity" => $quantity,

            "unit_type" => $tipe,

            //"rate" => unformat_currency($this->input->post('invoice_item_rate')),



           // "total" => $rate * $quantity,

        );



        $invoice_item_id = $this->Pengeluaran_model->save_item($invoice_item_data, $id);

		
			//Cek Data Kode Produk Sparepart
			$dtSparePt=$this->Pengeluaran_model->get_details_sparepart($kode);
			//$dtSparePt=$this->Pengeluaran_model->get_details_sparepart('SP1905032');
			//print_r($dtSparePt);
			$jmlBarangDBTersedia=$dtSparePt->saldo_perlengkapan;
			$jmlBarangDBKeluar=$dtSparePt->kuantitas_pengeluaran;
			$jmlBarang=$quantity;
			$saldoBarangTersedia=$jmlBarangDBTersedia-$jmlBarang;//Saldo Perlengkapan
			$saldoBarangKeluar=$jmlBarangDBKeluar+$jmlBarang;//Saldo Pengeluaran
			
			$spareprt_item_data = array(
				"saldo_perlengkapan" => $saldoBarangTersedia,
				"kuantitas_pengeluaran" => $saldoBarangKeluar, 
			);

			$update_mst_sparepart= $this->Pengeluaran_model->update_sparepart($spareprt_item_data, $kode);
			
		
        if ($invoice_item_id) {
				
			
			
			/*

            //check if the add_new_item flag is on, if so, add the item to libary. 

            $add_new_item_to_library = $this->input->post('add_new_item_to_library');

            if ($add_new_item_to_library) {

                $library_item_data = array(

                    "title" => $this->input->post('invoice_item_title'),

                    "category" => $this->input->post('category'),

                    "unit_type" => $tipe,

                    "rate" => unformat_currency($this->input->post('invoice_item_rate'))

                );

                $this->Master_Items_model->save($library_item_data);

            }



            $options = array("id" => $invoice_item_id);

            $item_info = $this->Purchase_InvoicesItems_model->get_details($options)->row();

            $pajak = 0;

            $invoice_sql = "SELECT purchase_invoices.*, tax_table.percentage AS tax_percentage, tax_table.title AS tax_name

            FROM purchase_invoices

            LEFT JOIN (SELECT taxes.* FROM taxes) AS tax_table ON tax_table.id = purchase_invoices.fid_tax

            WHERE purchase_invoices.deleted=0 AND purchase_invoices.id='$invoice_id'";

            $invoice = $this->db->query($invoice_sql)->row();



            $item  = $this->db->query("SELECT sum(total) as total from purchase_invoices_items WHERE fid_invoices = '$invoice_id'")->row();

            $pajak = $item->total * ($invoice->tax_percentage / 100);

            $query = array("amount" => $item->total + $pajak, "sub_total" => $item->total,'ppn' => $pajak);

                    $exe = $this->Purchase_Invoices_model->save($query,$invoice_id); )*/

            echo json_encode(array("success" => true, "invoice_id" => $invoice_id, "data" => $this->_make_item_row_bahan($item_info), 'id' => $invoice_item_id, 'message' => lang('record_saved')));

        } else {

            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));

        }

    }



    /* delete or undo an invoice item */



    function delete_itemo() {



        validate_submitted_data(array(

            "id" => "required|numeric"

        ));



        $id = $this->input->post('id');

        if ($this->input->post('undo')) {

            if ($this->Purchase_InvoicesItems_model->delete($id, true)) {

                $options = array("id" => $id);

                $item_info = $this->Purchase_InvoicesItems_model->get_details($options)->row();

                echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "data" => $this->_make_item_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), "message" => lang('record_undone')));

            } else {

                echo json_encode(array("success" => false, lang('error_occurred')));

            }

        } else {

            if ($this->Purchase_InvoicesItems_model->delete($id)) {

                $item_info = $this->Purchase_InvoicesItems_model->get_one($id);

                echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), 'message' => lang('record_deleted')));

            } else {

                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));

            }

        }

    }



	

    function jadi_modal_form($id) {



        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();

        $view_data['data_item_jadi'] = $this->Pengeluaran_model->master_item();

        $view_data['id'] = $id;

        $this->load->view('pengeluaran/jadi_modal_form',$view_data);

    }



    function modal_bahan_form_edit($id) {



	

        validate_submitted_data(array(

            "id" => "numeric"

        ));





        $id = $this->input->post('id');

        $options = array(

            "id" => $id,

        );



        //$view_data['model_info'] = $this->Pengeluaran_model->get_details_bahan($options)->row();



        //$this->load->view('pengeluaran/modal_form_edit', $view_data);

		

        //$view_data['data_warehouse'] = $this->Master_Warehouse_model->getWarehouseDrop();

        //$view_data['data_bahan'] = $this->Pengeluaran_model->persedian_material();

        $view_data['id'] = $id;

        $this->load->view('pengeluaran/modal_bahan_form_edit',$view_data);

    }



    function modal_form_edit() {



        validate_submitted_data(array(

            "id" => "numeric"

        ));





        $id = $this->input->post('id');

        $options = array(

            "id" => $id,

        );



        $view_data['model_info'] = $this->Pengeluaran_model->get_details($options)->row();



        $this->load->view('pengeluaran/modal_form_edit', $view_data);

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

			"code" => getCodeId('pengeluaran',"KL"),  

            "pr_id_kendaraan" => $this->input->post('id_kendaraan'),

            "pr_tanggal" => $this->input->post('tanggal'),

            "pr_keterangan" => $this->input->post('deskripsi'),

			"pr_createdby" => $this->session->userdata('user_name'),

            "pr_inputdata" => get_current_utc_time(),

            "deleted" =>0,

        );

		//print_r($item_data);

        

		$data = $this->Pengeluaran_model->save($item_data);

        if ($data) {

            $item_info = $this->Pengeluaran_model->get_maxi()->row();

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

			//"code" => getCodeId('Pengeluaran',"PR"),  

            "pb_Pengeluaran_id" => $idd,

            "pb_qty" => $jumlahQ,

            "pb_material_id" => $bahanQ,

			"pb_createdby" => $this->session->userdata('user_name'),

            "pb_timecreated" => get_current_utc_time(),

            "deleted" =>0,

        );

		//print_r($item_data); 

		$data = $this->Pengeluaran_model->simpan_bahan($item_data);

		

		//Item Dikurangi Ditambah

		$datapersediaan=$this->Pengeluaran_model->pilih_material($bahanQ);

		$saldoMaterial=$datapersediaan[0]->pm_saldo_material;

		$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;

		$saldoMatUpd=$saldoMaterial-$jumlahQ;

		$saldoKelUpd=$saldoKeluar+$jumlahQ;

		

        $item_material_update = array(

			//"code" => getCodeId('Pengeluaran',"PR"),  

            "pm_saldo_material" => $saldoMatUpd,

            "pm_kuantitas_keluar" => $saldoKelUpd,   

        );

		$updatepersediaan=$this->Pengeluaran_model->update_material($item_material_update,$bahanQ);

		

		

        if ($data) {

            $item_info = $this->Pengeluaran_model->get_details()->row();

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

			//"code" => getCodeId('Pengeluaran',"PR"),  

            "bj_Pengeluaran_id" => $idd, 

            "bj_kategori" => $bahanQ,

            "bj_qty" => $jumlahQ,

            "bj_harga" => $hargaQ,

            "bj_gudang" => $gudangQ,

			"bj_createdby" => $this->session->userdata('user_name'),

            "bj_timecreated" => get_current_utc_time(),

            "deleted" =>0,

        );

		//print_r($item_data); 

		$data = $this->Pengeluaran_model->simpan_jadi($item_data);

		

		/*

		//Item Dikurangi Ditambah

		$datapersediaan=$this->Pengeluaran_model->pilih_material($bahanQ);

		$saldoMaterial=$datapersediaan[0]->pm_saldo_material;

		$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;

		$saldoMatUpd=$saldoMaterial-$jumlahQ;

		$saldoKelUpd=$saldoKeluar+$jumlahQ;

		

        $item_material_update = array(

			//"code" => getCodeId('Pengeluaran',"PR"),  

            "pm_saldo_material" => $saldoMatUpd,

            "pm_kuantitas_keluar" => $saldoKelUpd,   

        );

		$updatepersediaan=$this->Pengeluaran_model->update_material($item_material_update,$bahanQ);

		*/

		

        if ($data) {

            $item_info = $this->Pengeluaran_model->get_details()->row();

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

		

		$codeprod=getCodeId('Pengeluaran',"PR");

		

         $item_data = array( 

            "code" => $codeprod,

            "pr_tanggal" => $this->input->post('tanggal'),

            "pr_keterangan" => $this->input->post('deskripsi'), 

            "pr_createdby" => $this->session->userdata('user_name'), 

            "pr_inputdata" => get_current_utc_time(),

            "deleted" =>0, 

        );

         //print_r($item_data);exit();

        $data = $this->Pengeluaran_model->save($item_data, $id);

		

		

		

		

		

        //echo $this->db->last_query();exit();

        if ($data) {

            $options = array("id" => $data);

            $item_info = $this->Pengeluaran_model->get_details($options)->row();

            echo json_encode(array("success" => true, "id" => $data, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));

        } else {

            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));

        }

    }







	

    function view($id= 0,$hal=FALSE){

        

        if ($id) {

				//echo $id;

            $view_data = get_detail_pengeluaran($id);

			

            if ($view_data) {

                $view_data['hal_aktif'] = $hal;

                $view_data['data_detail'] = $view_data;

                

                //$view_data['invoice_status_label'] = $this->_get_order_status_label($view_data["invoice_info"]);

					

                $this->template->rander("pengeluaran/view", $view_data);

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

            if ($this->Pengeluaran_model->delete($id, true)) {

                $options = array("id" => $id);

                $item_info = $this->Pengeluaran_model->get_details($options)->row();

                echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), "message" => lang('record_undone')));

            } else {

                echo json_encode(array("success" => false, lang('error_occurred')));

            }

        } else {

            if ($this->Pengeluaran_model->delete($id)) {

                $item_info = $this->Pengeluaran_model->get_one($id);

                echo json_encode(array("success" => true, "id" => $item_info->id, 'message' => lang('record_deleted')));

            } else {

                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));

            }

        }

    }





    function deleteitem() {



        validate_submitted_data(array(

            "id" => "required|numeric"

        ));



        $id = $this->input->post('id');

    

		$databa=$this->Pengeluaran_model->get_details_item(array('id'=>$id))->result();

		 

		if(count($databa)>0){

			/*

			$bahanQ=$databa[0]->pb_material_id;

			$jumlahQ=$databa[0]->pb_qty;

			if($bahanQ!=''){

				//Item Dikurangi Ditambah

				$datapersediaan=$this->Pengeluaran_model->pilih_material($bahanQ);

				$saldoMaterial=$datapersediaan[0]->pm_saldo_material;

				$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;

				$saldoMatUpd=$saldoMaterial+$jumlahQ;

				$saldoKelUpd=$saldoKeluar-$jumlahQ;

				

				$item_material_update = array(

					//"code" => getCodeId('Pengeluaran',"PR"),  

					"pm_saldo_material" => $saldoMatUpd,

					"pm_kuantitas_keluar" => $saldoKelUpd,   

				);

				$updatepersediaan=$this->Pengeluaran_model->update_material($item_material_update,$bahanQ);

				//$upoke=TRUE;

			}*/

			

			 

				if ($this->Pengeluaran_model->deleteItem($id)) {

					//$item_info = $this->Pengeluaran_model->get_one($id);

					

					

					

					echo json_encode(array("success" => true, "id" => '', 'message' => lang('record_deleted')));

					//echo json_encode(array("success" => true, "id" => '', 'message' => lang('record_deleted')));

				} else {

					echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));

				}

		}else {

					echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));

				}

    }

	

	

    function deletebahan() {



        validate_submitted_data(array(

            "id" => "required|numeric"

        ));



        $id = $this->input->post('id');

    

		$databa=$this->Pengeluaran_model->get_details_bahan(array('pb.id'=>$id))->result();

		//print_r($databa);

		//echo "window.alert('".$databa."')";

		

		if(count($databa)>0){

			

			$bahanQ=$databa[0]->pb_material_id;

			$jumlahQ=$databa[0]->pb_qty;

			if($bahanQ!=''){

				//Item Dikurangi Ditambah

				$datapersediaan=$this->Pengeluaran_model->pilih_material($bahanQ);

				$saldoMaterial=$datapersediaan[0]->pm_saldo_material;

				$saldoKeluar=$datapersediaan[0]->pm_kuantitas_keluar;

				$saldoMatUpd=$saldoMaterial+$jumlahQ;

				$saldoKelUpd=$saldoKeluar-$jumlahQ;

				

				$item_material_update = array(

					//"code" => getCodeId('Pengeluaran',"PR"),  

					"pm_saldo_material" => $saldoMatUpd,

					"pm_kuantitas_keluar" => $saldoKelUpd,   

				);

				$updatepersediaan=$this->Pengeluaran_model->update_material($item_material_update,$bahanQ);

				//$upoke=TRUE;

			}

			

			 

				if ($this->Pengeluaran_model->deleteBahan($id)) {

					//$item_info = $this->Pengeluaran_model->get_one($id);

					

					

					

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

         

            if ($this->Pengeluaran_model->deleteBarangjadi($id)) {

                //$item_info = $this->Pengeluaran_model->get_one($id);

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



        $list_data = $this->Pengeluaran_model->get_details()->result();

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

            $data->name, 



        );



		$row_data[] = anchor(get_uri("inventory/pengeluaran/view/".$data->id), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id));

            //. js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/pengeluaran/delete"), "data-action" => "delete"));

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

            $data->pm_saldo_Pengeluaran,

           // $data->pm_saldo_Pengeluaran,

            modal_anchor(get_uri("inventory/pengeluaran/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))

            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/pengeluaran/delete"), "data-action" => "delete"))

        );

		

		*/

    }

	

	

    function item_list_data($invoice_id = 0) {



        $list_data = $this->Pengeluaran_model->pengeluaran_barang_item(array("fid_pengeluaran" => $invoice_id,"deleted" => 0))->result();

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



        $bid=$data->id;

        $name=$data->title;

        $kode=$data->kode;

        //$code=$data->code;

        if($data->kode==$before){

            $name='';

        }

		

        $row_data = array( 

			 $data->title,

			 $data->category,

			 $data->description,

            $data->quantity.'',  



        );



		//$row_data[] = modal_anchor(get_uri("inventory/pengeluaran/modal_bahan_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))

          //  . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/pengeluaran/deletebahan"), "data-action" => "delete"));

            $row_data[] = js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $bid, "data-action-url" => get_uri("inventory/pengeluaran/deleteitem"), "data-action" => "delete"));



        return $row_data;



    }

	

    function updatebahan() {



        validate_submitted_data(array(

            "id" => "numeric"

        ));



        $id = $this->input->post('id');

		

		//$codeprod=getCodeId('Pengeluaran',"PR");

		

         $item_data = array( 

            //"code" => $codeprod,

            "pb_qty" => $this->input->post('jumlah'),

        );

         //print_r($item_data);exit();

        $data = $this->Pengeluaran_model->updatebahan($item_data, $id);

		

        //echo $this->db->last_query();exit();

        if ($data) {

            $options = array("id" => $data);

            //$item_info = $this->Pengeluaran_model->get_details($options)->row();

            echo json_encode(array("success" => true, "id" => $data, "data" => $this->_make_item_row_bahan($item_info), 'message' => lang('record_saved')));

        } else {

            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));

        }

    }



	

    function item_list_data_barangjadi($invoice_id = 0) {



        $list_data = $this->Pengeluaran_model->Pengeluaran_barangjadi(array("bj_Pengeluaran_id" => $invoice_id,"bj.deleted" => 0))->result();

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



		$row_data[] = js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $bid, "data-action-url" => get_uri("inventory/pengeluaran/deletebarangjadi"), "data-action" => "delete"));

		//$row_data[] = modal_anchor(get_uri("inventory/pengeluaran/modal_barangjadi_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))

        //    . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("inventory/pengeluaran/deletebarangjadi"), "data-action" => "delete"));



        return $row_data;



    }

     function get_item_suggestion_kendaraan() {

        $key = $this->input->get('q');

        $suggestion = array();


        $items3 = $this->Pengeluaran_model->get_item_suggestion_kendaraan($key);



        foreach ($items3 as $item) {

            $suggestion[] = array("id" => $item->id, "text" => $item->name .' - '. $item->nopol , "code" => $item->code, "id" => $item->id);

        }


        echo json_encode($suggestion);

    } 

    function get_item_info_suggestion_kendaraan() {


        $item0 = $this->Pengeluaran_model->get_item_info_suggestion_kendaraan($this->input->post("item_name"));
       

        $hit0=count($item0);


        if($hit0>0){

            $item=$item0;

        }

         

        if ($item) {

            echo json_encode(array("success" => true, "item_info" => $item));

        } else {

            echo json_encode(array("success" => false));

        }

    }



    function get_item_suggestion_pengeluaran() {

        $key = $this->input->get('q');

        $suggestion = array();



        $items0 = $this->Pengeluaran_model->get_item_suggestion($key);



        foreach ($items0 as $item) {

            $suggestion[] = array("id" => $item->title, "text" => $item->title, "price" => '' , "category" => 'Produksi',"unit_type" => '');

        }

		

        $items = $this->Pengeluaran_model->get_item_suggestion_sparepart($key);



        foreach ($items as $item) {

            $suggestion[] = array("id" => $item->title, "text" => $item->title, "description" => $item->deskripsi, "price" => '', "category" => 'Sparepart',"unit_type" => '');

        }



        $items2 = $this->Pengeluaran_model->get_item_suggestion_material($key);



        foreach ($items2 as $item) {

            $suggestion[] = array("id" => $item->pm_deskripsi, "text" => $item->pm_deskripsi, "price" => '' , "category" => 'Material', "unit_type" => '');

        }

        $items3 = $this->Pengeluaran_model->get_item_suggestion_kendaraan($key);



        foreach ($items3 as $item) {

            $suggestion[] = array("id" => $item->id, "text" => $item->name, "price" => '' , "category" => 'Material', "unit_type" => '');

        }



        //$suggestion[] = array("id" => "+", "text" => "+ " . lang("create_new_item"));



        echo json_encode($suggestion);

    } 

	

    function get_item_info_suggestion_pengeluaran() {

		

		$item0 = $this->Pengeluaran_model->get_item_info_suggestion($this->input->post("item_name"));

		$item1 = $this->Pengeluaran_model->get_item_info_suggestion_sparepart($this->input->post("item_name"));

		$item2 = $this->Pengeluaran_model->get_item_info_suggestion_material($this->input->post("item_name"));


		

		$hit0=count($item0);

		$hit1=count($item1);

		$hit2=count($item2);

		if($hit0>0){

			$item=$item0;

		}

		if($hit1>0){

			$item=$item1;

		}

		

		if($hit2>0){

			$item=$item2;

		}

		

		 

        if ($item) {

            echo json_encode(array("success" => true, "item_info" => $item));

        } else {

            echo json_encode(array("success" => false));

        }

    }

}



/* End of file Pengeluaran.php */

/* Location: ./application/controllers/Pengeluaran.php */